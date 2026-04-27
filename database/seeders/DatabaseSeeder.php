<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $manage1 = User::create([
            'name' => 'Manager1',
            'email' => 'manager1@gmail.com',
            'role' => 'manager',
            'password' => Hash::make('12345678')
        ]);
        $manage2 = User::create([
            'name' => 'Manager2',
            'email' => 'manager2@gmail.com',
            'role' => 'manager',
            'password' => Hash::make('12345678')
        ]);
    }
}
