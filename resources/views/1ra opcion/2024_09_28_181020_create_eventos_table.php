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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id('idEvento');
            $table->string('nombreEvento',100);
            $table->text('descripcionEvento');
            $table->string('urlImagen')->nullable();
            $table->timestamp('fechaHabilitacion')->nullable();
            $table->timestamp('fechaRealizacion')->nullable();
            $table->enum('estadoEvento', ['pendiente', 'suspendido', 'cancelado', 'agotado','terminado', 'disponible']);
           

            $table->foreignId('idUbicacion')->constrained('ubicaciones', 'idUbicacion')->onDelete('cascade');
            $table->foreignId('idCategoriaEvento')->constrained('categorias' , 'idCategoria')->onDelete('cascade');
            
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
