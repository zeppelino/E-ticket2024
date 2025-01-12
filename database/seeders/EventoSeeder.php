<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        for ($i = 0; $i < 10; $i++) {
            DB::table('eventos')->insert([
                'nombreEvento' => $faker->sentence(3), // Genera un título de 3 palabras
                'descripcionEvento' => $faker->paragraph, // Genera un párrafo de descripción
                'urlImagen' => $faker->imageUrl(640, 480, 'event'), // URL de imagen aleatoria o nula
                'fechaHabilitacion' => Carbon::now()->addDays($faker->numberBetween(0, 30)), // Fecha de habilitación aleatoria en los próximos 30 días
                'fechaRealizacion' => Carbon::now()->addDays($faker->numberBetween(30, 365)), // Fecha de realización aleatoria en el próximo año
                'estadoEvento' => $faker->randomElement(['pendiente', 'suspendido', 'cancelado', 'terminado', 'disponible','reprogramado']), // Estado aleatorio
                'idUbicacion' => $faker->numberBetween(1, 10), // ID de ubicación aleatoria (asegúrate de tener al menos 10 ubicaciones)
                'idCategoriaEvento' => $faker->numberBetween(1, 5), // ID de categoría aleatoria (asegúrate de tener al menos 5 categorías)
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
