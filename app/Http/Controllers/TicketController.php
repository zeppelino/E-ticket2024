<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function create(){
        return view('ticketForm');
    }

    public function crearEntrada($numeroEntrada, $idCliente, $tipoEntrada, $numeroTransaccion) {
        //
    }
}
