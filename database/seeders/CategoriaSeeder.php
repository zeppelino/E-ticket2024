<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        /* Categoria::factory(10)->create();
     */
        $categorias =  ['Concierto', 'Conferencia', 'Seminario', 'Festival', 'Fiesta', 'Exposición', 'Taller', 'Deportivo', 'Gala', 'Teatro', 'Webinar', 'Cine', 'Competencia', 'Networking', 'Lanzamiento de Producto', 'Feria', 'Encuentro Social', 'Charla', 'Concurso', 'Beneficencia'];


        foreach ($categorias as $categoria) {
            Categoria::create(['nombreCategoria' => $categoria]);
        }
    }
}
