<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\Neighborhood;
use Illuminate\Database\Seeder;

class ComplaintsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Vaciar la tabla
        Complaint::truncate();
        $faker = \Faker\Factory::create();
        //Asignacion de quejas ficticias a barrios
        $neighborhoods = Neighborhood::all();
        foreach ($neighborhoods as $neighborhood) {
            $num_complaint= rand(0, 3);
            for ($i = 0; $i < $num_complaint; $i++){
                Complaint::create([
                    'complaint'=> $faker->paragraph,
                    'username'=> $faker->name,
                    'email'=> $faker->email,
                    'state'=> 'Pendiente',
                    'observation'=>null,
                    'neighborhood_id'=> $neighborhood->id,
                    'truck_id'=>$neighborhood->truck_id
                ]);
            }
        }
    }
}
