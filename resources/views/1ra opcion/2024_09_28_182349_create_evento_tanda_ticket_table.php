<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  /*   public function up(): void
    {
        Schema::create('evento_tanda_ticket', function (Blueprint $table) {
            $table->foreignId('idEvento')->constrained('eventos', 'idEvento');
            $table->foreignId('idTanda')->constrained('tandas', 'idTanda');
            $table->foreignId('idTipoTicket')->constrained('tipo_tickets', 'idTipoTicket');
            $table->primary(['idEvento', 'idTanda', 'idTipoTicket']);
            $table->timestamps();
        });

    } */
    public function up(): void
    {
        Schema::create('evento_tanda_ticket', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental
            $table->foreignId('idEvento')->constrained('eventos', 'idEvento')->onDelete('cascade');
            $table->foreignId('idTanda')->constrained('tandas', 'idTanda')->onDelete('cascade');
            $table->foreignId('idTipoTicket')->constrained('tipo_tickets', 'idTipoTicket')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_tanda_ticket');
    }
};
