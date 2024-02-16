<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json(TaskResource::collection($tasks));
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

        // questo mi servirà una volta che oh tabella task_user per fare controllo che 
        //la start date la stia cambiando utente a cui è assegnato il task
        $user = $request->user()->id;

        $projectId = $task->project_id;
        $request->merge(['project_id' => $projectId]);
        
        $task->update($request->all());
        
        return response()->json(new TaskResource($task));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}