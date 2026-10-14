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

        User::factory()->create([
            'name' => 'Mario',
            'surname'=>'profesor',
            'email' => 'profesor@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'teacher'
        ]);

        User::create([
            'name' => 'juan',
            'surname'=>'alumno',
            'email' => 'alumno@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'student'
        ]);
    }
}
