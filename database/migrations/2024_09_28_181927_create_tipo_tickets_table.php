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
        Schema::create('tipo_tickets', function (Blueprint $table) {
            $table->id('idTipoTicket'); // PK 
            $table->unsignedBigInteger('idEvento'); // FK 
            $table->text('descripcionTipoTicket');
            $table->decimal('precioTicket', 10, 2);
            $table->integer('cupoTotal');
            $table->integer('cupoDisponible');
            $table->unsignedBigInteger('idCatTicket'); // FK 

            // Definición de las claves foráneas 
            $table->foreign('idEvento')->references('idEvento')->on('eventos')->onDelete('cascade');
            $table->foreign('idCatTicket')->references('idCatTicket')->on('categoria_ticket')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_tickets');
    }
};
