<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\ProjectRequest;

use App\Http\Controllers\ProjectAttachmentController;
use App\Http\Requests\ProjectAttachmentRequest;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $query = Project::orderBy("created_at");

        if (($request->has('month')) )
        {
            $months = $request->month;

            $query
            //->whereMonth('created_at', $month); // questa è una semplice WHERE
            ->whereIn(DB::raw('MONTH(created_at)'), $months); // questa è una WHERE con un IN(range)
        }

        if (($request->has('year')))
        {
            $years = $request->year;

            $query
            //->whereYear('created_at', $year);
            ->whereIn(DB::raw('YEAR(created_at)'), $years);
        }

        $projects = $query->get();
        return response()->json(ProjectResource::collection($projects));
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

      
        //
        //
        if ($request->has("file")) {
            //$parameterRequest = new Request;

            $parameterRequest = new ProjectAttachmentRequest;
            //$parameterRequest['file'] = $request->file;

            $parameterRequest->merge([
                'project_id' => $project->id,
                'user_id' => $request->user()->id
            ]);

            // Inserisci i file nella proprietà 'file'
            $parameterRequest->files->set('file', $request->file('file')); 
            //dd($parameterRequest);

            $project_attachments_controller = new ProjectAttachmentController;

            $project_attachments_controller->store($parameterRequest);
        }

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

        //quando modifico progetto voglio poter solo aggiungere progetti nuovi al massimo
        //per eliminarli non lo faccio con la update di questo controller
        //lo faccio direttamente con la destroy di questa constroller.
        if ($request->has("file")) {

            $parameterRequest = new ProjectAttachmentRequest;

            $parameterRequest->merge([
                'project_id' => $project->id,
                'user_id' => $request->user()->id
            ]);

            // Inserisci i file nella proprietà 'file'
            $parameterRequest->files->set('file', $request->file('file')); 
            
            $project_attachments_controller = new ProjectAttachmentController;

            $project_attachments_controller->store($parameterRequest);
        }
        
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