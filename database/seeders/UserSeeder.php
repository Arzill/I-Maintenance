<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'super.admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'), // password
            'role' => 'admin', // password
            'remember_token' => Str::random(10),
            'posisi' => 'admin',
        ]);
        User::create([
            'id' => 1,
            'name' => 'Ahmad',
            'email' => 'ahmad@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('ahmad123'), // password
            'role' => 'user', // password
            'remember_token' => Str::random(10),
            'posisi' => 'Staff',
        ]);
    }
}
