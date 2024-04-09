<?php

namespace Database\Seeders;

use App\Models\{TaskPriority};

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      TaskPriority::create([
        'name' => 'Bassa',
        'description' => 'Bassa priorità',
        'priority_level' => 1,
        'icon' => null,
        'color' => null
      ]);

      TaskPriority::create([
        'name' => 'Media',
        'description' => 'Media priorità',
        'priority_level' => 2,
        'icon' => null,
        'color' => null
      ]);

      TaskPriority::create([
        'name' => 'Alta',
        'description' => 'Alta priorità',
        'priority_level' => 3,
        'icon' => null,
        'color' => null
      ]);

      TaskPriority::create([
        'name' => 'Urgente',
        'description' => 'massima priorità',
        'priority_level' => 4,
        'icon' => null,
        'color' => null
      ]);

    }
}