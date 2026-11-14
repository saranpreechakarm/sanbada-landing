<?php

namespace App\Http\Controllers;

use App\Models\LineCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LineCrmController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        if (!Auth::attempt([...$credentials, 'can_access_line_crm' => true])) {
            return back()->withErrors(['email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง หรือไม่มีสิทธิ์ใช้งาน'])->onlyInput('email');
        }
        $request->session()->regenerate();

        return redirect()->route('crm.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('crm.login');
    }

    public function index(Request $request)
    {
        $filters = $request->validate(['q' => 'nullable|string|max:100', 'status' => ['nullable', Rule::in(array_keys(LineCustomer::STATUSES))]]);
        $query = LineCustomer::query();
        if ($q = $filters['q'] ?? null) {
            $query->where(function ($query) use ($q) {
                foreach (['display_name', 'nickname', 'phone', 'sales_owner'] as $field) {
                    $query->orWhere($field, 'like', '%'.$q.'%');
                }
                if (preg_match('/^(?:CUS-)?(\d+)$/i', $q, $match)) {
                    $query->orWhere('id', (int) $match[1]);
                }
            });
        }
        if ($status = $filters['status'] ?? null) {
            $query->where('status', $status);
        }

        return view('crm.index', ['customers' => $query->orderByDesc('last_contact_at')->paginate(30)->withQueryString()]);
    }

    public function update(Request $request, LineCustomer $customer)
    {
        $customer->update($request->validate([
            'nickname' => 'nullable|string|max:255', 'phone' => 'nullable|string|max:40',
            'sales_owner' => 'nullable|string|max:100', 'status' => ['required', Rule::in(array_keys(LineCustomer::STATUSES))],
        ]));

        return back()->with('saved', 'บันทึกข้อมูลลูกค้าแล้ว');
    }
}
