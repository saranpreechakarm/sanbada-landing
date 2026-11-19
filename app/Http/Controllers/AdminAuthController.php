<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        if (!Auth::attempt([...$credentials, 'can_manage_content' => true])) {
            return back()->withErrors(['email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง หรือบัญชีไม่มีสิทธิ์จัดการเว็บ'])->onlyInput('email');
        }
        $request->session()->regenerate();
        $request->session()->put('password_hash_'.Auth::getDefaultDriver(), $request->user()->getAuthPassword());
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function setup()
    {
        abort_if(User::where('can_manage_content', true)->exists(), 403, 'สร้างบัญชีผู้ดูแลแล้ว กรุณาเข้าสู่ระบบ');
        return view('admin.setup');
    }

    public function storeSetup(Request $request)
    {
        $this->setup();
        $data = $request->validate(['name' => 'required|string|max:100', 'email' => 'required|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(12)]]);
        // A singleton row serializes first-account creation, including an empty users table.
        DB::transaction(function () use ($data) {
            DB::table('content_admin_setup')->where('id', 1)->lockForUpdate()->first();
            abort_if(User::where('can_manage_content', true)->exists(), 403);
            $user = new User($data);
            $user->can_manage_content = true;
            $user->save();
        });
        return redirect()->route('admin.login')->with('saved', 'สร้างบัญชีแล้ว เข้าสู่ระบบเพื่อเริ่มจัดการเว็บ');
    }
}
