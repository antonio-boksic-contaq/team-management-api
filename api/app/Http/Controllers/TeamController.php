<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Resources\TeamResource;


class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Team::orderBy('id');

        if ($request['trashed'] == 1) $query->withTrashed();
        if ($request['trashed'] == 2) $query->onlyTrashed();
        
        return response()->json(TeamResource::collection($query->get()));
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
    public function store(TeamRequest $request)
    {
        $team = Team::create($request->all());
        return response()->json(new TeamResource($team));

    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return response()->json(new TeamResource($team));
    }

    public function delete(Team $team)
    {
        if (!$team) return response()->json(['message' => 'Team non trovato'], 404);
        
        $team->delete();

        return response()->json(['message' => 'Team cancellato con successo']);

    }

    public function restore($id)
    {
        return Team::withTrashed()->find($id)->restore() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }

  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamRequest $request, Team $team)
    {
        $team->update($request->all());
        
        return response()->json(new TeamResource($team));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}