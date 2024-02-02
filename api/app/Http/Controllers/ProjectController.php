<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projectPriorities = Project::all();
        return response()->json(ProjectResource::collection($projectPriorities));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {

        $project = Project::create($request->except('progress'));

        // questo sync funziona se non c'è il campo "users[]" nella request
        // non funziona però se questo campo è presente ma vuoto.
        // da capire come gestirla quando arriveremo al frontend.

        //questa era la sync vecchia che non teneva conto di colonne aggiuntive nella pivot
        //$project->users()->sync($request->get('users'));

        // da qui implementiamo la gestione della colonna "supervisor"
        // Associa gli utenti con i valori del campo "supervisor" in base alla richiesta

        $idsOfUsers= $request->get('users');

        if ( $request->has("supervisor"))
        {
            $supervisorData = [];
            $supervisorValues = $request->get('supervisor');

            foreach ($idsOfUsers as $index => $userId) {
                $supervisor = $supervisorValues[$index];
                $supervisorData[$userId] = ['supervisor' => $supervisor];
            }

            //dd($supervisorData);
            $project->users()->sync($supervisorData);
        } else {
            $project->users()->sync($idsOfUsers);
        }

        return response()->json(new ProjectResource($project->load('users')));

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return response()->json(new ProjectResource($project->load('users')));
    }

    public function delete(Project $project)
    {
        if (!$project) return response()->json(['message' => 'Progetto non trovato'], 404);
        
        $project->delete();
        return response()->json(['message' => 'Progetto cancellato con successo']);
    }

    public function restore($id)
    {
        return Project::withTrashed()->find($id)->restore() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->except('progress'));
        
        // vedere commenti della store se poco chiaro
        $idsOfUsers= $request->get('users');

        if ( $request->has("supervisor"))
        {
            $supervisorData = [];
            $supervisorValues = $request->get('supervisor');

            foreach ($idsOfUsers as $index => $userId) {
                $supervisor = $supervisorValues[$index];
                $supervisorData[$userId] = ['supervisor' => $supervisor];
            }

            //dd($supervisorData);
            $project->users()->sync($supervisorData);
        } else {
            $project->users()->sync($idsOfUsers);
        }

        return response()->json(new ProjectResource($project));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}