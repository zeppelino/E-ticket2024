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
            $table->id('idTipoTicket');
            $table->enum('nombreTipoTicket',['vip', 'campo', 'general', 'gratis','premium']);
            $table->text('descripcionTipoTicket', 100);
            $table->decimal('precioTicket', 8, 2);
            $table->integer('cupoTotal');
            $table->integer('cupoDisponible');
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
