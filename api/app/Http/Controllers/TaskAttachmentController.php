<?php

namespace App\Http\Controllers;

use App\Models\TaskAttachment;
use Illuminate\Http\Request;
use App\Http\Resources\TaskAttachmentResource;
use App\Http\Requests\TaskAttachmentRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class TaskAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskAttachments= TaskAttachment::all();
        return response()->json(TaskAttachmentResource::collection($taskAttachments));
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
    public function store(TaskAttachmentRequest $request)
    {
        
        // DEVO TROVARE I FILE NELLA REQUEST
        $files = $request->file('file');
        // $files può essere pure un array a questo punto
        // quindi da qui che partiva la gestione del singolo file in precedenza...
        // va gestita tutta con un ciclo for

        $timestamp = Carbon::now()->timestamp;
        $taskAttachments = [];

        foreach ($files as $file) {
            $original_name = $file->getClientOriginalName();
            $file_name = $timestamp."_".$original_name;

            // DEVO CARICARE FILE NELLO STORAGE
            $projectId = $request->project_id;
            $taskId = $request->task_id;
            Storage::putFileAs('projects'."/".$projectId."/"."tasks"."/".$taskId, $file , $file_name);

            // DEVO INSERIRE FILE_PATH NEL DATABASE
            // il file_path si riferisce alla cartella public, perchè è da quella che il sito prende i file
            // creo il file_path e lo inserisco nella request insieme al $original_name che userò in frontend
            $file_path = "/projects/".$projectId."/"."tasks"."/".$taskId."/".$file_name;
            $request->merge(['file_path' => $file_path, 'original_name' => $original_name]);
            $taskAttachment = TaskAttachment::create($request->except('file'));

            $taskAttachments[] = $taskAttachment;
        }
        
        return response()->json(TaskAttachmentResource::collection($taskAttachments));
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskAttachment $taskAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskAttachment $taskAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskAttachment $taskAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskAttachment $taskAttachment)
    {
        //
    }

    public function download(TaskAttachment $taskAttachment)
    {
        // potrei fare dei controlli di sicurezza qui per vedere se utente può effettivamente fare download
        //ad esempio controllare se utente/supervisore è associato al progetto
        
        //return $projectAttachment->file_path;
        //qua a me serve storage/app/Projects/idprogetto/filename
        return response()->download(storage_path('app' . $taskAttachment->file_path));
    }
}