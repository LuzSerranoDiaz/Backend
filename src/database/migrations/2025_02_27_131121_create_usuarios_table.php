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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('contraseña');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('tlf');
            $table->string('direccion');
            $table->string('municipio');
            $table->string('provincia');
            $table->rememberToken();
            $table->timestamps();
        });
        /*         Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
 */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
        /* Schema::dropIfExists('password_reset_tokens'); */
    }
};
