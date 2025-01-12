<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BeneficioSeeder extends Seeder
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

        // Crear 10 beneficios aleatorios
        for ($i = 0; $i < 10; $i++) {
            DB::table('beneficios')->insert([
                'porcentaje' => $faker->numberBetween(5, 50), // Porcentaje entre 5% y 50%
                'fechaInicioBeneficio' => $faker->dateTimeBetween('-1 months', 'now'), // Fecha de inicio aleatoria entre el mes pasado y ahora
                'fechaFinBeneficio' => $faker->dateTimeBetween('now', '+1 months'), // Fecha de fin aleatoria entre ahora y el próximo mes
                'idEvento' => $faker->numberBetween(1, 10), // Suponiendo que ya tienes eventos con ids entre 1 y 10
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
