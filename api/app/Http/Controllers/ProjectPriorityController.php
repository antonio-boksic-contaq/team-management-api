<?php

namespace App\Http\Controllers;

use App\Models\ProjectPriority;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectPriorityResource;
use App\Http\Requests\ProjectPriorityRequest;

class ProjectPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projectPriorities = ProjectPriority::all();
        return response()->json(ProjectPriorityResource::collection($projectPriorities));
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
    public function store(ProjectPriorityRequest $request)
    {
        $projectPriority = ProjectPriority::create($request->all());
        return response()->json(new ProjectPriorityResource($projectPriority));

    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectPriority $projectPriority)
    {
        return response()->json(new ProjectPriorityResource($projectPriority));
    }

    public function delete(ProjectPriority $projectPriority)
    {
        if (!$projectPriority) return response()->json(['message' => 'Priorità non trovata'], 404);
        
        $projectPriority->delete();
        return response()->json(['message' => 'Priorità cancellata con successo']);
    }

    public function restore($id)
    {
        return ProjectPriority::withTrashed()->find($id)->restore() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectPriority $projectPriority)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectPriority $projectPriority)
    {
        $projectPriority->update($request->all());
        
        return response()->json(new ProjectPriorityResource($projectPriority));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectPriority $projectPriority)
    {
        //
    }
}
