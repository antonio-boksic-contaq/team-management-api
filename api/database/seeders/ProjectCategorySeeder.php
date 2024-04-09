<?php

namespace Database\Seeders;

use App\Models\{ProjectCategory};

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      ProjectCategory::create([
        'name' => 'Corsi',
        'description' => 'corsi di formazione per risorse interne',

      ]);

      ProjectCategory::create([
        'name' => 'Startup',
        'description' => 'caricamento liste',

      ]);

      ProjectCategory::create([
        'name' => 'Sviluppo Sfotware',
        'description' => 'sviluppo software interno',

      ]);
    }
}