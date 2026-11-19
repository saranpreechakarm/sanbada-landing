<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.users', ['users' => User::where('can_manage_content', true)->orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:100', 'email' => 'required|email|max:255|unique:users',
            'current_password' => 'bail|required|string|max:1024|current_password',
            'password' => ['required', 'confirmed', Password::min(12)]]);
        $user = new User(collect($data)->except('current_password')->all());
        $user->can_manage_content = true;
        $user->save();
        return back()->with('saved', 'เพิ่มผู้ดูแลแล้ว กรุณาส่งรหัสผ่านให้เจ้าของบัญชีอย่างปลอดภัย และให้เปลี่ยนหลังเข้าสู่ระบบ');
    }

    public function update(Request $request, User $user)
    {
        abort_unless($user->can_manage_content, 404);
        $data = $request->validate(['action' => 'required|in:revoke,reset',
            'current_password' => 'bail|required|string|max:1024|current_password',
            'password' => ['required_if:action,reset', 'nullable', 'confirmed', Password::min(12)]]);
        if ($data['action'] === 'revoke') {
            abort_if($request->user()->is($user), 422, 'ไม่สามารถยกเลิกสิทธิ์บัญชีที่กำลังใช้งานได้');
            $user->can_manage_content = false;
        } else {
            $user->password = $data['password'];
        }
        $user->save();
        return back()->with('saved', 'ปรับปรุงบัญชีแล้ว');
    }

    public function password(Request $request)
    {
        $data = $request->validate(['current_password' => 'bail|required|string|max:1024|current_password',
            'password' => ['required', 'confirmed', Password::min(12)]]);
        $request->user()->update(['password' => $data['password']]);
        $request->session()->regenerate();
        return back()->with('saved', 'เปลี่ยนรหัสผ่านแล้ว');
    }
}
