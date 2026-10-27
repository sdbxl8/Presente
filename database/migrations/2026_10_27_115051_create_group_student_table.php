<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_student', function (Blueprint $table) {
            $table->foreignId('group_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['group_id', 'student_id']);
        });

        // Migrar las asignaciones existentes a la nueva tabla.
        $now = now();

        $existingAssignments = DB::table('users')
            ->where('role', 'student')
            ->whereNotNull('group_id')
            ->get(['id', 'group_id']);

        foreach ($existingAssignments as $student) {
            DB::table('group_student')->insertOrIgnore([
                'group_id' => $student->group_id,
                'student_id' => $student->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('group_student');
    }
};
