<?php

namespace Database\Seeders;

use App\Models\{ProjectApplicant};

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class ProjectApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      ProjectApplicant::create([
        'name' => 'Contaq',
        'description' => 'questi sono i nostri progetti interni',
      ]);

      ProjectApplicant::create([
        'name' => 'Unicef',
        'description' => null,
      ]);

      ProjectApplicant::create([
        'name' => 'MSF',
        'description' => 'Medici Senza Frontiere',
      ]);
    }
}