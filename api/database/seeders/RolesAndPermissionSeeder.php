<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions

        //Permission::create(['name' => 'edit articles']);

        $sections = [
            'project applicant',
            'project attachment',
            'project category',
            'project priority',
            'project status',
            'project',
            'task priority',
            'task status',
            'task',
            'task attachment',
            'team',
            'user',  
        ];
        /*
        'project_applicants'  supervisore
        'project_attachments' supervisore + utente
        'project_categories' supervisore
        'project_priorities' supervisore
        'project_statuses' supervisore
        'projects' supervisore
        'task priorities' supervisore
        'task_statuses' supervisore
        'tasks' supervisore + utente
        'teams' supervisore
        'users' supervisore 
        */

        // create roles and assign created permissions

        $basePermissions = [];

        foreach ($sections as $section) {

            if($section == "task") {
                $basePermissions[] = [
                    'name' => 'change task status' ,
                ];
            }

            $basePermissions[] = [
                'name' => 'create ' . $section,
            ];

            $basePermissions[] = [
                'name' => 'see ' . $section,
            ];

            $basePermissions[] = [
                'name' => 'update ' . $section,
            ];

            $basePermissions[] = [
                'name' => 'delete ' . $section,
            ];

            $basePermissions[] = [
                'name' => 'restore ' . $section,
            ];

        }

        $permissions = collect($basePermissions)->map(function ($permission) {
            return ['name' => $permission['name'], 'guard_name' => 'web'];
        });

        //inserisco i permessi nella loro tabella
        Permission::insert($permissions->toArray());

        // DA QUI GESTISCO I RUOLI

        // Supervisore ha tutti i permessi
        $role = Role::create(['name' => 'Supervisore']);
        $role->givePermissionTo(Permission::all());

        //Collaboratore
        $role = Role::create(['name' => 'Collaboratore',]);
        $role->givePermissionTo(Permission::where('name', 'like', '%project attachment%')// qua gli do tutti i permessi che contengono "project attachment"
                                            ->orWhere('name', 'like', '%task%') // qua gli do tutti i permessi che contengono "project"
                                            ->orWhere('name', 'like', '%see%')->get()); // qua gli do tutti i permessi che contengono "see"
        $role->givePermissionTo(['change task status']); // qua gli do permesso "change task status"
        

        //$role = Role::create(['name' => 'Mauro']);
    }
}