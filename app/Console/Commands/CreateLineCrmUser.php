<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateLineCrmUser extends Command
{
    protected $signature = 'crm:create-user';
    protected $description = 'Create a dedicated staff login for the LINE CRM';

    public function handle(): int
    {
        $data = ['name' => $this->ask('Staff name'), 'email' => $this->ask('Email'),
            'password' => $this->secret('Password (at least 12 characters)'),
            'password_confirmation' => $this->secret('Confirm password')];
        $validator = Validator::make($data, ['name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:12|confirmed']);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) { $this->error($error); }
            return self::FAILURE;
        }
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->can_access_line_crm = true;
        $user->save();
        $this->info('CRM staff account created.');

        return self::SUCCESS;
    }
}
