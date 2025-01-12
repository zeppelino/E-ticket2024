<?php

namespace Database\Seeders;

use App\Models\CategoriaTicket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CategoriaTicketSeeder extends Seeder
{
    public function run(): void
    {
   
        $catTickets =  ['General', 'Vip', 'Campo', 'Gratis'];


        foreach ($catTickets as $catTicket) {
            CategoriaTicket::create(['nombreCatTicket' => $catTicket]);
        }
    }
}