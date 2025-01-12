<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EntradaSeeder extends Seeder
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

        // Crear 10 entradas aleatorias
        for ($i = 0; $i < 10; $i++) {
            DB::table('entradas')->insert([
                'numeroEntrada' => $faker->unique()->bothify('ENT###???'), // Genera un número de entrada único con formato alfanumérico
                'numeroTransaccion' => $faker->optional()->bothify('TRX###???'), // Número de transacción opcional, con formato alfanumérico
                'fechaCompra' => $faker->optional()->dateTimeBetween('-1 months', 'now'), // Fecha de compra opcional dentro del último mes
                'idTipoTicket' => $faker->numberBetween(1, 10), // Suponiendo que ya tienes ticket con ids entre 1 y 10
                'idUsuario' => $faker->numberBetween(1, 10), // Suponiendo que ya tienes usuarios con ids entre 1 y 10
                'precio'=>$faker->randomFloat(2, 10, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
