<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TipoTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear una instancia de Faker
        $faker = Faker::create();

        // Obtener todos los eventos existentes para asignar un idEvento aleatorio
        $eventos = DB::table('eventos')->pluck('idEvento')->toArray();

        // Crear 10 tipos de tickets aleatorios
        for ($i = 0; $i < 10; $i++) {
            $cupoTotal = $faker->numberBetween(50, 500); // Cupo total aleatorio entre 50 y 500
            $cupoDisponible = $faker->numberBetween(0, $cupoTotal); // Cupo disponible menor o igual al cupo total

            DB::table('tipo_tickets')->insert([
                'idEvento' => $faker->randomElement($eventos), // Selecciona un evento aleatorio
                'descripcionTipoTicket' => $faker->text(100), // Descripción del tipo de ticket
                'precioTicket' => $faker->randomFloat(2, 10, 500), // Precio del ticket entre 10.00 y 500.00
                'cupoTotal' => $cupoTotal, // Cupo total
                'cupoDisponible' => $cupoDisponible, // Cupo disponible
                'idCatTicket' => $faker->numberBetween(1, 4), // Asignar un idCatTicket aleatorio (suponiendo que hay categorías con ids del 1 al 10)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
    }
}
