<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request)
    {
        $data = $request->validated();

        $data['whatsapp_phone'] = preg_replace('/\s+/', '', $data['whatsapp_phone']);

        Lead::create($data);

        // ✅ ส่งไปหน้า thankyou พร้อม query file (ถ้ามี)
        $file = ltrim($data['pdf'] ?? '', '/');

        if ($file && Str::startsWith($file, 'assets/projects/pdf/')) {
            return redirect()->route('thankyou', ['file' => $file, 'project' => $data['project'] ?? null]);
        }

        return redirect()->route('thankyou');
    }

    // ✅ endpoint โหลด pdf
    public function downloadPdf(Request $request)
    {
        $file = ltrim($request->query('file', ''), '/');

        // allow เฉพาะใน assets/projects เท่านั้น
        if (!$file || !Str::startsWith($file, 'assets/projects/pdf/')) {
            abort(404);
        }

        $fullPath = public_path($file);
        if (!file_exists($fullPath)) abort(404);

        return response()->download($fullPath, basename($fullPath), [
            'Content-Type' => 'application/pdf',
        ]);
    }
}