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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->foreignId('idUsuario')->constrained('users' ,'id');
            $table->foreignId('idEvento')->constrained('eventos', 'idEvento');
            $table->timestamp('fechaInscripcion')->nullable();
            $table->enum('estadoVenta', ['pendiente', 'confirmado', 'cancelado']);
            $table->enum('estadoEnvio', ['pendiente', 'enviado']);
            $table->primary(['idUsuario', 'idEvento']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
