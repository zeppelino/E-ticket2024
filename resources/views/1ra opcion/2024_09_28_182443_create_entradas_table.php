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
        Schema::create('entradas', function (Blueprint $table) {
            $table->id('idEntrada');
            $table->string('numeroEntrada');
            $table->string('numeroTransaccion')->nullable();
            $table->timestamp('fechaCompra')->nullable();
            $table->foreignId('idTipoTicket')->constrained('tipo_tickets', 'idTIpoTicket');
            $table->foreignId('idEvento')->constrained('eventos', 'idEvento');
            $table->foreignId('idTanda')->constrained('tandas', 'idTanda');
            $table->foreignId('idUsuario')->constrained('users', 'id');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};
