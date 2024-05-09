<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\ProjectRequest;

use App\Http\Controllers\ProjectAttachmentController;
use App\Http\Requests\ProjectAttachmentRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{ProjectsExport};

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        
        $query = Project::orderBy("created_at");
    
        // FILTRI 
        if($request->has('month')) $query->whereIn(DB::raw('MONTH(created_at)'), explode(',',$request->get('month')));
        if ($request->has('year')) $query->whereIn(DB::raw('YEAR(created_at)'), explode(',',$request->get('year')));
        if ($request['trashed'] == 1 ) $query->withTrashed();
        if ($request['trashed'] == 2 ) $query->onlyTrashed();
    
        // SOLO PROGETTI ASSOCIATI ALL'UTENTE
        if ($request->has('myProjects') && $request->input('myProjects') === "true") {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where('users.id', $request->user()->id);
            });
        }
    
        $projects = $query->get();
    
        if($request->has('export')){
            return Excel::download(new ProjectsExport(ProjectResource::collection($projects), $request->has('trashed')), 'progetti.xlsx');
        }
        
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
        //dd($request);
        $project = Project::create($request->except('progress'));

        if ($request->has("file")) {

            $parameterRequest = new ProjectAttachmentRequest;

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

        $idsOfSupervisors = $request->get('supervisors');

        //creo un array unico da usare per il sync
        $combinedIds = [];

        foreach ($idsOfUsers as $userId) {
            $combinedIds[$userId] = ['supervisor' => 0]; // imposto supervisor = 0 per utenti normali
        }
        foreach ($idsOfSupervisors as $supervisorId) {
            $combinedIds[$supervisorId] = ['supervisor' => 1]; //  imposto supervisor = 1 per supervisori
        }

        $project->users()->sync($combinedIds);

        return response()->json(new ProjectResource($project->load('users')));

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return response()->json(new ProjectResource($project->load(['users','projectAttachments'])));
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

        $idsOfSupervisors = $request->get('supervisors');

        //creo un array unico da usare per il sync
        $combinedIds = [];

        foreach ($idsOfUsers as $userId) {
            $combinedIds[$userId] = ['supervisor' => 0]; // imposto supervisor = 0 per utenti normali
        }
        foreach ($idsOfSupervisors as $supervisorId) {
            $combinedIds[$supervisorId] = ['supervisor' => 1]; //  imposto supervisor = 1 per supervisori
        }

        $project->users()->sync($combinedIds);

        return response()->json(new ProjectResource($project));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
    public function years(Request $request)
    {
        return Project::select(DB::raw('YEAR(created_at) as id'), DB::raw('YEAR(created_at) as year'))
        ->whereNotNull('created_at')
        ->orderBy('year','desc')
        ->distinct()
        ->get();
    }
}