<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanda extends Model
{
    use HasFactory;

    protected $table = 'tandas';
    protected $primaryKey = 'idTanda'; // Especifica la clave primaria
    public $incrementing = true; // Indica que es autoincremental
    protected $keyType = 'int'; // Tipo de dato de la clave primaria

    protected $fillable = [
        'idEvento',
        'idTanda',
        'nombreTanda',
        'fechaInicio',
        'fechaFin',
        'cupos',
        'estadoTanda'
    ];

    public function evento()
{
    return $this->belongsTo(Evento::class, 'idEvento', 'idEvento');
}


}
