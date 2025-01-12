<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaTicket extends Model
{
    use HasFactory;

    protected $table = 'categoria_ticket';
    protected $primaryKey = 'idCatTicket';

    protected $fillable = [
        'nombreCatTicket',
    ];

    // Relación con los tipos de tickets que pertenecen a esta categoría
    public function tipoTickets()
    {
        return $this->hasMany(TipoTicket::class, 'idCatTicket', 'idCatTicket');
    }
}
