<?php

namespace App\Http\Controllers;

use App\Models\TaskComment;
use Illuminate\Http\Request;
use App\Http\Resources\TaskCommentResource;

class TaskCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskComments= TaskComment::all();
        return response()->json(TaskCommentResource::collection($taskComments));
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
    public function store(Request $request)
    {
        // da frontend nella request mi mando task_id e content
        // poi aggiungo user_id da backend
        $request->merge(['user_id' => $request->user()->id,]);
        $taskComment = TaskComment::create($request->all());
        return response()->json(new TaskCommentResource($taskComment));
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskComment $taskComment)
    {
        return response()->json(new TaskCommentResource($taskComment));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskComment $taskComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskComment $taskComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskComment $taskComment)
    {
        //
    }
}