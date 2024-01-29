<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use App\Http\Resources\TaskStatusResource;
use App\Http\Requests\TaskStatusRequest;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskStatuses = TaskStatus::all();
        return response()->json(TaskStatusResource::collection($taskStatuses));

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
    public function store(TaskStatusRequest $request)
    {
        $taskStatus = TaskStatus::create($request->all());
        return response()->json(new TaskStatusResource($taskStatus));

    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $taskStatus)
    {
        return response()->json(new TaskStatusResource($taskStatus));
    }

    public function delete(TaskStatus $taskStatus)
    {
        if (!$taskStatus) return response()->json(['message' => 'Stato non trovata'], 404);
        
        $taskStatus->delete();
        return response()->json(['message' => 'Stato cancellato con successo']);
    }

    public function restore($id)
    {
        return TaskStatus::withTrashed()->find($id)->restore() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $taskStatus->update($request->all());
        
        return response()->json(new TaskStatusResource($taskStatus));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        //
    }
}
