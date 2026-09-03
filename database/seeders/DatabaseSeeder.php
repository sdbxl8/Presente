<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Group;
use App\Models\Subject;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $teacher = User::factory()->create([
            'name' => 'Mario',
            'surname'=>'profesor',
            'email' => 'profesor@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'teacher'
        ]);

        $group = Group::create([
            'name' => '1º DAW A',
            'teacher_id' => $teacher->id,
        ]);

        Subject::create([
            'name' => 'Programación',
            'group_id' => $group->id,
        ]);

        Subject::create([
            'name' => 'Bases de datos',
            'group_id' => $group->id,
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
