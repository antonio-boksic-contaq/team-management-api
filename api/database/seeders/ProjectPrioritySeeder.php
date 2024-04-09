<?php

namespace Database\Seeders;

use App\Models\{ProjectPriority};

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      ProjectPriority::create([
        'name' => 'Bassa',
        'description' => 'Bassa priorità',
        'priority_level' => 1,
        'icon' => null,
        'color' => null
      ]);

      ProjectPriority::create([
        'name' => 'Media',
        'description' => 'Media priorità',
        'priority_level' => 2,
        'icon' => null,
        'color' => null
      ]);

      ProjectPriority::create([
        'name' => 'Alta',
        'description' => 'Alta priorità',
        'priority_level' => 3,
        'icon' => null,
        'color' => null
      ]);

      ProjectPriority::create([
        'name' => 'Urgente',
        'description' => 'massima priorità',
        'priority_level' => 4,
        'icon' => null,
        'color' => null
      ]);

    }
}