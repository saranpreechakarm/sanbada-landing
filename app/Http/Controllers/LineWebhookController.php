<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LineWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $secret = config('line_crm.channel_secret');
        abort_unless(is_string($secret) && $secret !== '', 503);
        $expected = base64_encode(hash_hmac('sha256', $request->getContent(), $secret, true));
        abort_unless(hash_equals($expected, (string) $request->header('x-line-signature')), 401);
        $payload = json_decode($request->getContent(), true);
        abort_unless(is_array($payload) && isset($payload['events']) && is_array($payload['events']), 400);

        foreach ($payload['events'] as $event) {
            if (!is_array($event) || !in_array($event['type'] ?? '', ['message', 'follow'], true)
                || ($event['source']['type'] ?? '') !== 'user') {
                continue;
            }
            $userId = $event['source']['userId'] ?? null;
            $eventId = $event['webhookEventId'] ?? null;
            // LINE may omit userId when profile access consent is unavailable.
            if ($userId === null) {
                continue;
            }
            abort_unless(is_string($userId) && preg_match('/^U[0-9a-f]{32}$/', $userId)
                && is_string($eventId) && strlen($eventId) > 0 && strlen($eventId) <= 100
                && is_numeric($event['timestamp'] ?? null), 400);
            if (DB::table('line_webhook_events')->where('event_id', $eventId)->exists()) {
                continue;
            }
            $contactAt = Carbon::createFromTimestampMs($event['timestamp'], config('app.timezone', 'UTC'))->format('Y-m-d H:i:s');
            $name = null;
            if (config('line_crm.access_token')) {
                try {
                    $profile = Http::withToken(config('line_crm.access_token'))->connectTimeout(2)->timeout(4)
                        ->get('https://api.line.me/v2/bot/profile/'.$userId);
                    if ($profile->successful() && is_string($profile->json('displayName'))) {
                        $name = mb_substr($profile->json('displayName'), 0, 255);
                    }
                } catch (\Illuminate\Http\Client\ConnectionException $exception) {
                    // Keep the customer even when the profile service is temporarily unavailable.
                }
            }
            DB::transaction(function () use ($eventId, $userId, $contactAt, $name) {
                if (!DB::table('line_webhook_events')->insertOrIgnore([
                    'event_id' => $eventId, 'created_at' => now(),
                ])) {
                    return;
                }
                DB::table('line_customers')->insertOrIgnore([
                    'line_user_id' => $userId, 'display_name' => $name, 'status' => 'new',
                    'first_contact_at' => $contactAt, 'last_contact_at' => $contactAt,
                    'created_at' => now(), 'updated_at' => now(),
                ]);
                $customer = DB::table('line_customers')->where('line_user_id', $userId)->lockForUpdate()->first();
                DB::table('line_customers')->where('id', $customer->id)->update([
                    'display_name' => $name ?? $customer->display_name,
                    'first_contact_at' => min($customer->first_contact_at, $contactAt),
                    'last_contact_at' => max($customer->last_contact_at, $contactAt),
                    'updated_at' => now(),
                ]);
            });
        }

        return response()->json(['ok' => true]);
    }
}
