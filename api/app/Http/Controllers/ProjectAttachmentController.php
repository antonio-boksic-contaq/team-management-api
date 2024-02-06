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
        // DEVO TROVARE FILE NELLA REQUEST
        $file = $request->file('file');

        // DEVO DARE UN NOME AL FILE
        // preparo timestamp
        $timestamp = Carbon::now()->timestamp;

        // devo sapere di che progetto si parla (potrei inserire project_id nel form che viene mandato nella request)
        $project = Project::find($request->project_id);
        // devo sapere chi è utene che sta caricando il file (potrei inserire user_id nel form che viene mandato nella request)
        $user = User::find($request->user_id);

        $file_name = $project->id ."_"./*$project->name."_".*/$timestamp."_".$user->name ."_".$user->lastname . ".pdf";

        // DEVO CARICARE FILE NELLO STORAGE
        Storage::putFileAs('projects', $file , $file_name);

        // DEVO INSERIRE FILE_PATH NEL DATABASE
        // il file_path si riferisce alla cartella public, perchè è da quella che il sito prende i file
        // creo il file path e lo inserisco nella request
        $file_path = "/projects/".$file_name;
        $request->merge(['file_path' => $file_path]);
        $projectAttachment = ProjectAttachment::create($request->except('file'));
        
        return response()->json(new ProjectAttachmentResource($projectAttachment));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectAttachment $projectAttachment)
    {
        return response()->json(new ProjectAttachmentResource($projectAttachment));
    }

    public function delete(ProjectAttachment $projectAttachment)
    {
       return $projectAttachment->delete() ?
       response()->json(["error" => false, "message" => "allegato eliminato con successo"]) :
       response()->json(["error"=> true, "message"=> "errore con eliminazione dell'allegato"]);
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
        // se ho file nella richiesta
        if ($request->has("file")) {
            // mi salvo nome del file vecchio
            $oldFileName = explode("/", $projectAttachment->file_path);
            // devo inserire nuovo file nel database
            $timestamp = Carbon::now()->timestamp;
            $project = Project::find($request->project_id);
            $user = User::find($request->user_id);
            $file_name = "provaprova".$project->id ."_"./*$project->name."_".*/$timestamp."_".$user->name ."_".$user->lastname . ".pdf";
            Storage::putFileAs('projects', $request->file('file') , $file_name);

            // devo aggiornare record nel database cambiando anche file_path
            $file_path = '/projects/'.$file_name; 
            $request->merge(['file_path' => $file_path]);
            $projectAttachment->update($request->all());

            // devo eliminare vecchio file (se esiste)            
            Storage::disk('projects')->delete($oldFileName[2]);
        }
        // se non ho file nella richiesta aggiorno quello che ho e basta
        else {
            $projectAttachment->update($request->all());
        }
        return new ProjectAttachmentResource($projectAttachment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectAttachment $projectAttachment)
    {
        //
    }
}