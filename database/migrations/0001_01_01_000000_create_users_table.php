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
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('surname');

            $table->string('email')->unique();
            $table->string('password');

            //Establecer rol de usuario
            $table->enum('role', [
                'teacher',
                'student'
            ]);

            $table->string('photo')->nullable();
            $table->string('career')->nullable();
            $table->unsignedTinyInteger('course')->nullable();

            $table->rememberToken();

            $table->foreignId('group_id')->nullable();//para evitar errores, creamos la columna pero sin FK,
                                                      //para crear otra posterior donde añadir las restricciones
                                                      //de esta forma evitamos errores de procesamiento de tablas

            $table->timestamps();
         });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
