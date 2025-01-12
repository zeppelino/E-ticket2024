<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UbicacionSeeder extends Seeder
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

        // Crear 10 ubicaciones aleatorias
        for ($i = 0; $i < 10; $i++) {
            DB::table('ubicaciones')->insert([
                'país' => $faker->country,
                'provincia' => $faker->state,
                'ciudad' => $faker->city,
                'direccion' => $faker->streetAddress,
            ]);
        }
    }
}
