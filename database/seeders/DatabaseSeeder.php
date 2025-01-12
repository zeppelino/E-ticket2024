<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

 use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        ]); */

        /* Factory para las categorias */
        /* Categoria::factory(10)->create();

         */
        //ejecuta todos los seeders en el orden en que estan abajo: php artisan db:seed
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategoriaTicketSeeder::class,
            CategoriaSeeder::class,
          /*   UbicacionSeeder::class,
            EventoSeeder::class,
            BeneficioSeeder::class,
            TandaSeeder::class,
            TipoTicketSeeder::class,
            InscripcionSeeder::class,
            EntradaSeeder::class, */
            WorldSeeder::class,

            // Agrega más seeders según sea necesario
            //borra todas las tablas y ejecuta todso los seders al mismo tiempo:
            //php artisan migrate:fresh --seed
        ]);
    }
}
