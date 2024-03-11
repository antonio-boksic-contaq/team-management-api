<?php

namespace App\Http\Controllers;

use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectCategoryResource;
use App\Http\Requests\ProjectCategoryRequest;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project_categories = ProjectCategory::all();
        return response()->json(ProjectCategoryResource::collection($project_categories));
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
    public function store(ProjectCategoryRequest $request)
    {
        $project_category = ProjectCategory::create($request->all());
        return response()->json(new ProjectCategoryResource($project_category));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectCategory $projectCategory)
    {
        return response()->json(new ProjectCategoryResource($projectCategory));
    }

    public function delete(ProjectCategory $projectCategory)
    {
        if (!$projectCategory) return response()->json(['message' => 'Categoria non trovata'], 404);
        
        $projectCategory->delete();
        return response()->json(['message' => 'Categoria cancellata con successo']);
    }

    public function restore($id)
    {
        return ProjectCategory::withTrashed()->find($id)->restore() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectCategory $projectCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectCategoryRequest $request, ProjectCategory $projectCategory)
    {
        $projectCategory->update($request->all());
        
        return response()->json(new ProjectCategoryResource($projectCategory));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectCategory $projectCategory)
    {
        //
    }
}