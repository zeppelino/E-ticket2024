<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Categoria::class;

    public function definition(): array
    {
        
        return [
            /* 'nombreCategoria'=>$this->faker->randomElement(['Fiesta', 'Festival','Musica', 'Concierto', 'Teatro', 'Deportivo']),
            'created_at' => now(),                      
            'updated_at' => now() */
        ];
    }
}
