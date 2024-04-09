<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Requests\TaskRequest;
use Carbon\Carbon;
use App\Http\Requests\TaskAttachmentRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Task::orderBy("created_at");

        if (($request->has('project_id')) )
        {
            $query->where('project_id', $request->project_id);
        }

        return response()->json(TaskResource::collection($query->get()));
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
    public function store(TaskRequest $request)
    {
        $task = Task::create($request->all());

        if ($request->has("file")) {

            $parameterRequest = new TaskAttachmentRequest;

            $parameterRequest->merge([
                'task_id' => $task->id,
                'user_id' => $request->user()->id,
                'project_id' => $task->project_id,
            ]);

            // Inserisci i file nella proprietà 'file'
            $parameterRequest->files->set('file', $request->file('file')); 
            //dd($parameterRequest);

            $task_attachments_controller = new TaskAttachmentController;

            $task_attachments_controller->store($parameterRequest);
        }

        $task->users()->sync($request->users);

        return response()->json(new TaskResource($task));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json(new TaskResource($task));
    }

    public function delete(Task $task)
    {
        if (!$task) return response()->json(['message' => 'Task non trovato'], 404);
        
        $task->delete();
        return response()->json(['message' => 'Task cancellato con successo']);
    }

    public function restore($id)
    {
        return Task::withTrashed()->find($id)->restore() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $projectId = $task->project_id;
        $request->merge(['project_id' => $projectId]);
        
        $task->update($request->all());
        $task->users()->sync($request->users);
        
        return response()->json(new TaskResource($task));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    public function change_status(Request $request, Task $task) 
    {
        $validatedData = $request->validate([
            'task_status_id' => 'required|numeric|exists:task_statuses,id'
        ]);

        //questo lo metto null in caso utente abbia selezionato "completato" per sbaglio e poi cambiato
        $validatedData['end_date'] = null;

        //se utente seleziona "completato" metto una end_date
        if ($validatedData['task_status_id'] == 4) 
        {
            $validatedData['end_date'] =Carbon::now('Europe/Rome')->toDateTimeString();
        }

        $task->update($validatedData);

        //
        // da qui gestisco status del progetto associato al task
        $project = $task->project()->first();
        $project_tasks =  $project->tasks()->get();

        // array che contiene task iniziati (in realtà che non sono "da iniziare")
        //questi possono essere pure completati
        $at_least_initiated_project_tasks = $project->tasks()->where("task_status_id","<>" , 1)->get();
        // trovo tutti i task associati al progetto che sono completati
        $finalized_project_tasks = $project->tasks()->where("task_status_id", 4)->get();

        //preparo una variabile booleana da usare in un if dopo
        $all_project_tasks_are_completed = count($project_tasks) === count($finalized_project_tasks);

        // se array che contiene task iniziati non è vuoto
        // e se non tutti i task sono completati
        if (!$at_least_initiated_project_tasks->isEmpty() && !$all_project_tasks_are_completed) {
            //allora metti
            $project->update(["project_status_id" => 2]);  
        }
        // o se tutti i task sono completati mi metti "completato" anche al progetto
        else if ($all_project_tasks_are_completed) $project->update(["project_status_id" => 4]); 

        // finito gestione status del progetto associato al task

        return response()->json(new TaskResource($task));
    }
}