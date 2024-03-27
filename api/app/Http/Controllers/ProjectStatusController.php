<?php

namespace App\Http\Controllers;

use App\Models\ProjectStatus;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectStatusResource;
use App\Http\Requests\ProjectStatusRequest;

class ProjectStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProjectStatus::orderBy('id');

        if ($request['trashed'] == 1) $query->withTrashed();
        if ($request['trashed'] == 2) $query->onlyTrashed();
        
        return response()->json(ProjectStatusResource::collection($query->get()));
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
    public function store(ProjectStatusRequest $request)
    {
        $projectStatus = ProjectStatus::create($request->all());
        return response()->json(new ProjectStatusResource($projectStatus));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectStatus $projectStatus)
    {
        return response()->json(new ProjectStatusResource($projectStatus));
    }

    public function delete(ProjectStatus $projectStatus)
    {
        if (!$projectStatus) return response()->json(['message' => 'Stato non trovata'], 404);
        
        $projectStatus->delete();
        return response()->json(['message' => 'Stato cancellato con successo']);
    }

    public function restore($id)
    {
        return ProjectStatus::withTrashed()->find($id)->restore() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectStatus $projectStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectStatus $projectStatus)
    {
        $projectStatus->update($request->all());
        
        return response()->json(new ProjectStatusResource($projectStatus));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectStatus $projectStatus)
    {
        //
    }
}