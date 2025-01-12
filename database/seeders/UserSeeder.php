<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin Seeder
        User::create([
            'name' => 'Admin', 
            'lastName' => 'Prueba', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'profileImage' => "1729278981.png"
        ])->assignRole('Admin');

        //Cliente Seeder

        User::create([
            'name' => 'Cliente', 
            'lastName' => 'Prueba', 
            'email' => 'cliente@gmail.com',
            'password' => bcrypt('12345678'),
            'profileImage' => "1729278981.png"
        ])->assignRole('Cliente');
/* 
        // Crear una instancia de Faker
        $faker = Faker::create();

        // Crear 10 usuarios aleatorios
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->firstName,
                'lastName' => $faker->lastName,
                'profileImage' => $faker->imageUrl(640, 480, 'people', true, 'Faker'), // Imagen aleatoria de perfil
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $faker->optional()->dateTimeThisYear(), // Verificado opcional
                'password' => Hash::make('123456789'), // Usando un hash para la contraseña
                //'rememberToken' => $faker->regexify('[A-Za-z0-9]{10}'), 
                'created_at' => now(),
                'updated_at' => now(),
            ])->assignRole('Cliente');
        } */
    }
}
