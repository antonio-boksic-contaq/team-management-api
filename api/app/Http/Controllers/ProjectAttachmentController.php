<?php

namespace App\Http\Controllers;

use App\Models\ProjectAttachment;
use App\Models\Project;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectAttachmentRequest;
use App\Http\Resources\ProjectAttachmentResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProjectAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projectAttachments= ProjectAttachment::all();
        return response()->json(ProjectAttachmentResource::collection($projectAttachments));
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
    public function store(ProjectAttachmentRequest $request)
    {
        // DEVO TROVARE I FILE NELLA REQUEST
        $files = $request->file('file');
        // $files può essere pure un array a questo punto
        // quindi da qui che partiva la gestione del singolo file in precedenza...
        // va gestita tutta con un ciclo for

        $timestamp = Carbon::now()->timestamp;
        $projectAttachments = [];

        foreach ($files as $file) {
            $original_name = $file->getClientOriginalName();
            $file_name = $timestamp."_".$original_name;

            // DEVO CARICARE FILE NELLO STORAGE
            $projectId = $request->project_id;
            Storage::putFileAs('projects'."/".$projectId, $file , $file_name);

            // DEVO INSERIRE FILE_PATH NEL DATABASE
            // il file_path si riferisce alla cartella public, perchè è da quella che il sito prende i file
            // creo il file_path e lo inserisco nella request insieme al $original_name che userò in frontend
            $file_path = "/projects/".$projectId."/".$file_name;
            $request->merge(['file_path' => $file_path, 'original_name' => $original_name]);
            $projectAttachment = ProjectAttachment::create($request->except('file'));

            $projectAttachments[] = $projectAttachment;
        }
        
        return response()->json(ProjectAttachmentResource::collection($projectAttachments));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectAttachment $projectAttachment)
    {
        return response()->json(new ProjectAttachmentResource($projectAttachment));
    }

    public function restore($id)
    {
        $projectAttachment = ProjectAttachment::withTrashed()->find($id);
        
        return $projectAttachment->restore() ? 
        response()->json(["error" => false, "message" => "allegato ripristinato con successo"]) :
        response()->json(["error"=> true, "message"=> "errore con ripristino dell'allegato"]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectAttachment $projectAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectAttachmentRequest $request, ProjectAttachment $projectAttachment)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectAttachment $projectAttachment)
    {

        if (Storage::disk('projects')->delete($projectAttachment->file_path)) {
            
            $projectAttachment->delete();
            return response()->json(['error' => 'false']);
        
        } else {

            return response()->json(['error' => 'true']);
        }
    }

    public function download(ProjectAttachment $projectAttachment)
{
    // potrei fare dei controlli di sicurezza qui per vedere se utente può effettivamente fare download
    //ad esempio controllare se utente/supervisore è associato al progetto
    
    //return $projectAttachment->file_path;
    //qua a me serve storage/app/Projects/idprogetto/filename
    return response()->download(storage_path('app' . $projectAttachment->file_path));
}
}