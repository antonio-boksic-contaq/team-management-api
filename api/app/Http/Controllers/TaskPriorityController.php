<?php

namespace App\Http\Controllers;

use App\Models\TaskPriority;
use Illuminate\Http\Request;
use App\Http\Resources\TaskPriorityResource;
use App\Http\Requests\TaskPriorityRequest;

class TaskPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskPriorities = TaskPriority::all();
        return response()->json(TaskPriorityResource::collection($taskPriorities));
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
    public function store(TaskPriorityRequest $request)
    {
        $taskPriority = TaskPriority::create($request->all());
        return response()->json(new TaskPriorityResource($taskPriority));
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskPriority $taskPriority)
    {
        return response()->json(new TaskPriorityResource($taskPriority));
    }

    public function delete(TaskPriority $taskPriority)
    {
        if (!$taskPriority) return response()->json(['message' => 'Priorità non trovata'], 404);
        
        $taskPriority->delete();
        return response()->json(['message' => 'Priorità cancellata con successo']);
    }

    public function restore($id)
    {
        return TaskPriority::withTrashed()->find($id)->restore() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskPriority $taskPriority)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskPriorityRequest $request, TaskPriority $taskPriority)
    {
        $taskPriority->update($request->all());
        
        return response()->json(new TaskPriorityResource($taskPriority));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskPriority $taskPriority)
    {
        //
    }
}
