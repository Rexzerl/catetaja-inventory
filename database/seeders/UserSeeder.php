<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //admin account
        User::create([
            'name' => 'Admin',
            'email' => 'admin123@gmail.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1
        ]);

        //staff account
        User::create([
            'name' => 'Staff',
            'email' => 'staff123@gmail.com',
            'password' => Hash::make('staff123'),
            'role_id' => 2
        ]);

        //manager account
        User::create([
            'name' => 'Manager',
            'email' => 'manager123@gmail.com',
            'password' => Hash::make('manager123'),
            'role_id' => 3
        ]);

    }
}
