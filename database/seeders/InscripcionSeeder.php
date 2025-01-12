<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class InscripcionSeeder extends Seeder
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

        // Definir los posibles estados de venta y envío
        $estadosVenta = ['pendiente', 'confirmado', 'cancelado'];
        $estadosEnvio = ['pendiente', 'enviado'];

        // Crear 10 inscripciones aleatorias
        for ($i = 0; $i < 10; $i++) {
            DB::table('inscripciones')->insert([
                'idUsuario' => $i+1, // Suponiendo que ya tienes usuarios con ids entre 1 y 10
                'idEvento' => $i+1,  // Suponiendo que ya tienes eventos con ids entre 1 y 10
                'fechaInscripcion' => $faker->dateTimeBetween('-1 months', 'now'), // Fecha aleatoria en el último mes
                'estadoVenta' => $faker->randomElement($estadosVenta), // Estado de venta aleatorio
                'estadoEnvio' => $faker->randomElement($estadosEnvio), // Estado de envío aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
