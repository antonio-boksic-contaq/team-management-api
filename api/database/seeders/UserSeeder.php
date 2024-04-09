<?php

namespace Database\Seeders;

use App\Models\{InternalTrainingSession, ContractClassification, ContractDuty, ContractRejectionReason, ContractSector, ContractType, TrainingCourse, User, UserContract, Headquarter};
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        

        $supervisor = User::create([
            'name' => 'Mattia',
            'lastname' => 'Musumeci',
            'email' => 'mattia.musumeci@contaq.it',
            'password' => Hash::make('password'),
            'gender' => 'M',
            'team_id' => 1
        ]);
        $supervisor->assignRole('Supervisore');

        $collaborator = User::create([
          'name' => 'Antonio',
          'lastname' => 'Boksic',
          'email' => 'antonio.boksic@contaq.it',
          'password' => Hash::make('password'),
          'gender' => 'M',
          'team_id' => 1
      ]);
      $collaborator->assignRole('Collaboratore');

      }
}