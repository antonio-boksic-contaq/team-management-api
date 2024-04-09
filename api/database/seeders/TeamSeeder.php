<?php

namespace Database\Seeders;

use App\Models\{Team};

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      Team::create([
        'name' => 'IT',
        'description' => 'team tech',
      ]);

      Team::create([
        'name' => 'HR',
        'description' => 'team risorse umane',
      ]);

     }
}