<?php

namespace Database\Seeders;

use App\Models\{TaskStatus};

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      TaskStatus::create([
        'name' => 'Da iniziare',
        'description' => 'task non ancora iniziati',
        'icon' => null,
        'color' => null
      ]);

      TaskStatus::create([
        'name' => 'In corso',
        'description' => 'task iniziati ma non completati',
        'icon' => null,
        'color' => null
      ]);

      TaskStatus::create([
        'name' => 'Completato',
        'description' => 'task completati',
        'icon' => null,
        'color' => null
      ]);


    }
}