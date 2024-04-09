<?php

namespace Database\Seeders;

use App\Models\{Project};
use Carbon\Carbon;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $project = Project::create([
        'name' => 'Corso Vue su Udemy',
        'description' => 'Corso introduttivo su Vue obbligatorio per sviluppatori appena entrati',
        'notes' => 'link del corso: www.udemy.com',
        'project_priority_id' => 3,
        'deadline_date' => Carbon::now()->addMonth(),
        'project_status_id' => 1,
        'project_applicant_id' => 1,
        'project_category_id' => 1,
      ]);

      //ripreso codice dal controller per fare questo sync, probabilmente c'è un modo migliore per farlo...
      $idsOfUsers= [2];
      $idsOfSupervisors = [1];

      foreach ($idsOfUsers as $userId) {
        $combinedIds[$userId] = ['supervisor' => 0]; // imposto supervisor = 0 per utenti normali
    }
    foreach ($idsOfSupervisors as $supervisorId) {
        $combinedIds[$supervisorId] = ['supervisor' => 1]; //  imposto supervisor = 1 per supervisori
    }

    $project->users()->sync($combinedIds);



    }
}