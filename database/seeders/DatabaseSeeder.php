<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    \App\Models\User::create([
        'name' => 'Admin Toko',
        'email' => 'admin@fpwlaravel.test',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'role' => 'admin',
    ]);

    \App\Models\User::create([
        'name' => 'Kasir Rina',
        'email' => 'kasir@fpwlaravel.test',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'role' => 'kasir',
    ]);
}
}
