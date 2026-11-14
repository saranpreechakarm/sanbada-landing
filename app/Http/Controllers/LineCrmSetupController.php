<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class LineCrmSetupController extends Controller
{
    public function show()
    {
        abort_if(User::where('can_access_line_crm', true)->exists(), 403);
        return response()->view('crm.setup')->header('Cache-Control', 'private, no-store')->header('Referrer-Policy', 'no-referrer');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:12|confirmed']);
        Cache::lock('line-crm-initial-account', 10)->block(3, function () use ($data) {
            abort_if(User::where('can_access_line_crm', true)->exists(), 403);
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->can_access_line_crm = true;
            $user->save();
        });
        return redirect()->route('crm.login')->with('saved', 'สร้างบัญชีแล้ว เข้าสู่ระบบได้เลย');
    }
}
