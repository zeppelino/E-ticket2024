<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'idEvento'; 

    protected $fillable = [
        'nombreEvento', 
        'descripcionEvento', 
        'urlImagen',
        'fechaHabilitacion', 
        'fechaRealizacion', 
        'estadoEvento', 
        'idUbicacion', 
        'idCategoriaEvento',
    ];


      // Relación con la ubicación
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'idUbicacion', 'idUbicacion');
    }

    // Relación con la categoría del evento
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoriaEvento', 'idCategoria');
    }

    // Relación con los tipos de tickets asociados a este evento
    public function tipoTickets()
    {
        return $this->hasMany(TipoTicket::class, 'idEvento', 'idEvento');
    }

    // Relación con los beneficios del evento
    public function beneficios()
    {
        return $this->hasMany(Beneficio::class, 'idEvento', 'idEvento');
    }

    // Relación con las tandas del evento
    public function tandas()
    {
        return $this->hasMany(Tanda::class, 'idEvento', 'idEvento');
    }



}
