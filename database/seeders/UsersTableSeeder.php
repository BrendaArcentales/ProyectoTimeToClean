<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaciar la tabla
        User::truncate();
        $faker = \Faker\Factory::create();
        // Crear la misma clave para todos los usuarios
        // conviene hacerlo antes del for para que el seeder
        // no se vuelva lento.
        $password = Hash::make('123123');
        User::create([
            'name'=> 'Administrador',
            'lastname'=> 'General',
            'birthdate'=> '1973-12-3',
            'type'=> '',
            'email'=> 'admin@prueba.com',
            'password'=> $password,
            'role'=> User::ROLE_SUPERADMIN,
            'cellphone'=> '0987202894',
            ]);

        // Generar algunos usuarios conductores para nuestra aplicacion
        for($i = 0; $i < 5 ; $i++) {
            User::create([
                'name'=> $faker->firstName,
                'lastname'=> $faker->lastName,
                'birthdate'=> $faker->date($format = 'Y-m-d', $max = 'now'),
                'type'=> $faker->randomElement(['Principal','Suplente']),
                'email'=> $faker->email,
                'password'=> $password,
                'role'=> User::ROLE_DRIVER,
                'cellphone'=> '0969055431',
            ]);
        }
    }
}
