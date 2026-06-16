<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PemilikSeeder extends Seeder
{
    public function run()
    {
   User::firstOrCreate(
    ['email' => 'owner@gmail.com'],
    [
        'name' => 'Pemilik Kalisawah',
        'password' => Hash::make('12345678'),
        'role' => 'pemilik'
    ]
);
    }
}