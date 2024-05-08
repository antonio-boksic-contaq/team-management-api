<?php

namespace Database\Seeders;

use App\Models\{Task};
use Carbon\Carbon;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $task = Task::create([
        'name' => 'iscriversi a piattaforma Udemy',
        'description' => 'è necessario fare un account per vedere il corso',
        'notes' => 'usare password sicura per favore',
        'task_priority_id' => 1,
        'start_date' => Carbon::now(),        
        'deadline_date' => Carbon::now()->addMonth(),
        'task_status_id' => 3, // completato
        'time_difficulty_score' => 1,
        'project_id' => 1
      ]);

      $idsOfUsers= [2];
      $task->users()->sync($idsOfUsers);

      $task = Task::create([
        'name' => 'Fare effettivamente il corso',
        'description' => 'seguire tutte le lezioni',
        'notes' => 'si possono fare anche esercizi in piattaforma dopo ogni lezione',
        'task_priority_id' => 1,
        'start_date' => Carbon::now(),        
        'deadline_date' => Carbon::now()->addMonth(),
        'task_status_id' => 1, // Da iniziare
        'time_difficulty_score' => 10,
        'project_id' => 1
      ]);

      $idsOfUsers= [2];
      $task->users()->sync($idsOfUsers);


    }
}