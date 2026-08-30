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
        Schema::create('class_sessions', function (Blueprint $table) {
            $table->id();

            // Asignatura a la que pertenece esta clase.
            // Una asignatura puede tener muchas clases/sesiones.
            $table->foreignId('subject_id')
                ->constrained('subjects')
                ->cascadeOnDelete();

            // Día concreto de la clase.
            $table->date('date');

            // Hora de inicio y finalización.
            $table->time('start_time');
            $table->time('end_time');

            // Estado de la clase: programada, abierta o cerrada.
            $table->string('status')->default('scheduled');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_sessions');
    }
};
