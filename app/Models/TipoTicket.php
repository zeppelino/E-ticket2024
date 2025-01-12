<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Faker\Factory as Faker;

class TipoTicket extends Model
{
    use HasFactory;

    protected $table = 'tipo_tickets';
    protected $primaryKey = 'idTipoTicket';

    protected $fillable = [
        'idTipoTicket',
        'idCatTicket',
        'descripcionTipoTicket',
        'precioTicket',
        'cupoTotal',
        'cupos',
        'cupoDisponible',
        'idEvento'
    ];

      // Relación con Evento a través de la tabla pivote 
        // belongsTo indica una relación de muchos-a-uno
 /*      public function eventos()
      {
          return $this->belongsTo(Evento::class, 'idEvento', 'idEvento');
      }
 */
      public function categoriaTicket()
      {
          return $this->belongsTo(CategoriaTicket::class, 'idCatTicket', 'idCatTicket');
      }

      public function entradas()
        {
            return $this->hasMany(Entrada::class, 'idTipoTicket', 'idTipoTicket');
        }


      // Relación con el evento al que pertenece este tipo de ticket
      public function evento()
      {
          return $this->belongsTo(Evento::class, 'idEvento', 'idEvento');
      }

      /* CREAR LA ENTRADA -- cambiar al controlador si se puede */
    /*   public function crearEntrada($numeroTransaccion, $idUsuario, $precio, $tipoTicket)
      {
          $faker = Faker::create(); // Crear instancia de Faker
  
          return $this->entradas()->create([
              'numeroEntrada' => $faker->unique()->bothify('ENT###???'), // Número de entrada único
              'numeroTransaccion' => $numeroTransaccion,
              'fechaCompra' => now(),
              'idUsuario' => $idUsuario,
              'idTipoTicket'=> $tipoTicket->idTipoTicket, 
              'precio' => $precio,
              'created_at' => now(),
              'updated_at' => now(),
          ]);
      } */

     
}
