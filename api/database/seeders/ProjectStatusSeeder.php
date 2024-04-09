<?php

namespace Database\Seeders;

use App\Models\{ProjectStatus};

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      ProjectStatus::create([
        'name' => 'Da iniziare',
        'description' => 'progetti confermati ma non ancora iniziati',
        'icon' => null,
        'color' => null
      ]);

      ProjectStatus::create([
        'name' => 'In corso',
        'description' => 'progetti iniziati ma non completati',
        'icon' => null,
        'color' => null
      ]);

      ProjectStatus::create([
        'name' => 'Completato',
        'description' => 'progetti completati',
        'icon' => null,
        'color' => null
      ]);

      ProjectStatus::create([
        'name' => 'Bloccato',
        'description' => 'progetti bloccati per motivi vari',
        'icon' => null,
        'color' => null
      ]);

      ProjectStatus::create([
        'name' => 'Slittato',
        'description' => 'progetti da riprendere più avanti',
        'icon' => null,
        'color' => null
      ]);

      ProjectStatus::create([
        'name' => 'Da Valutare',
        'description' => 'progetti non ancora confermati',
        'icon' => null,
        'color' => null
      ]);
    }
}