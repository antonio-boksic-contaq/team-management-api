<?php

namespace App\Http\Controllers;

use App\Models\ProjectApplicant;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectApplicantResource;
use App\Http\Requests\ProjectApplicantRequest;

class ProjectApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProjectApplicant::orderBy('name');

        if ($request['trashed'] == 1) $query->withTrashed();
        if ($request['trashed'] == 2) $query->onlyTrashed();
        
        return response()->json(ProjectApplicantResource::collection($query->get()));
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
    public function store(ProjectApplicantRequest $request)
    {
        $project_category = ProjectApplicant::create($request->all());
        return response()->json(new ProjectApplicantResource($project_category));

    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectApplicant $projectApplicant)
    {
        return response()->json(new ProjectApplicantResource($projectApplicant));
    }

    public function delete(ProjectApplicant $projectApplicant)
    {
        if (!$projectApplicant) return response()->json(['message' => 'Committente non trovato'], 404);
        
        $projectApplicant->delete();
        return response()->json(['message' => 'Committente cancellato con successo']);
    }

    public function restore($id)
    {
        return ProjectApplicant::withTrashed()->find($id)->restore() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectApplicant $projectApplicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectApplicant $projectApplicant)
    {
        $projectApplicant->update($request->all());
        
        return response()->json(new ProjectApplicantResource($projectApplicant));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectApplicant $projectApplicant)
    {
        //
    }
}