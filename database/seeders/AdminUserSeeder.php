<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {//заводим первого админа
        User::create([
            'name' => 'admin',
            'email' => 'admin@techstore.ru',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);
    }
}