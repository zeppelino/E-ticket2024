<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficio extends Model
{
    use HasFactory;

    protected $table = 'beneficios';
    protected $primaryKey = 'idBeneficio'; 

    protected $fillable = [
        'porcentaje',
        'fechaInicioBeneficio',
        'fechaFinBeneficio',
        'idEvento',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'idEvento');
    }
}
