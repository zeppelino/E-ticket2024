<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    protected $table = 'entradas';
    protected $primaryKey = 'idEntrada';

    protected $fillable = [
        'numeroEntrada',
        'numeroTransaccion',
        'fechaFinBeneficio',
        'fechaCompra',
        'precio',
        'idTipoTicket',
        'idUsuario',
    ];



    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario', 'id');
    }

    public function tipoTickets()
    {
        return $this->belongsTo(TipoTicket::class, 'idTipoTicket', 'idTipoTicket');
    }

}
