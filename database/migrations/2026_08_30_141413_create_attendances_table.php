<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            // Clase a la que corresponde la asistencia.
            $table->foreignId('class_id')
                ->constrained('classes')
                ->cascadeOnDelete();

            // Alumno que realiza la asistencia.
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Estado de la asistencia:
            // present, late, absent o excused.
            $table->enum('status', [
                'present',
                'late',
                'absent',
                'excused'
            ]);

            // Momento exacto en el que el alumno registró su asistencia.
            $table->timestamp('registered_at')->nullable();

            $table->timestamps();

            // Un alumno solo puede tener una asistencia por clase.
            $table->unique(['class_id', 'user_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
