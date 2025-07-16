<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan model User di-import

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambahkan baris ini untuk menghapus data lama sebelum seeding

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone_number' => '085263508932',
            'address' => 'Jalan Pakuan no 3',
            'gender' => 'male',
            'image' => 'profile-image/elvinson.png',
            'role' => 'admin',
            'password' => bcrypt('password'), 
        ]);

        User::create([
            'name' => 'Elvinson Wijaya',
            'username' => 'elvinson',
            'email' => 'elvinso@gmail.com',
            'phone_number' => '085263506419',
            'address' => 'RTB BCA',
            'gender' => 'male',
            'image' => 'profile-image/elvinson.png',
            'role' => 'user',
            'password' => bcrypt('password'), 
            'points' => 200
        ]);
        
        User::factory(5)->create([
            'image' => 'profile-image/elvinson.png',
        ]);

    }
}