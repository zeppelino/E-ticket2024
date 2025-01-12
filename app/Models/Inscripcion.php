<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';
    protected $primaryKey = 'idInscripcion';

    protected $fillable = [
        'idUsuario',
        'idEvento',
        'idInscripcion',
        'fechaInscripcion',
        'estadoVenta',
        'estadoEnvio'
    ];

    // Relación con el usuario (modelo User)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario', 'id'); // Relaciona con el modelo User, usando 'idUsuario' como clave foránea
    }

    // Relación con el evento
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'idEvento', 'idEvento'); // Relaciona con el modelo Evento, usando 'idEvento' como clave foránea
    }
}
