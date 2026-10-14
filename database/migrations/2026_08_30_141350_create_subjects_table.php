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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
           // Asignatura a la que pertenece esta clase.
            // Un grupo puede tener varias asignaturas.
            $table->foreignId('group_id')
                  ->constrained('groups')
                  ->cascadeOnDelete();

            // Nombre de la asignatura.
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
