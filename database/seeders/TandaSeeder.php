<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TandaSeeder extends Seeder
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

        // Crear 10 tandas aleatorias
        for ($i = 0; $i < 10; $i++) {
            // Fechas aleatorias para inicio y fin de la tanda
            $fechaInicio = $faker->dateTimeBetween('-1 months', '+1 months'); // Fecha de inicio entre el mes pasado y el próximo mes
            $fechaFin = $faker->dateTimeBetween($fechaInicio, '+1 months'); // Fecha de fin después de la fecha de inicio

            DB::table('tandas')->insert([
                'idEvento' => $faker->numberBetween(1, 10), // Suponiendo que ya tienes eventos con ids entre 1 y 10
                'nombreTanda' => $faker->words(3, true), // Genera un nombre para la tanda con 3 palabras
                'fechaInicio' => $fechaInicio, // Fecha de inicio aleatoria
                'fechaFin' => $fechaFin, // Fecha de fin aleatoria
                'cupos' => $faker->numberBetween(50, 200), // Cupos totales entre 50 y 200
                'estadoTanda' => 'pendiente', // Valor fijo para estadoTanda
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
