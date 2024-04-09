<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendPassword;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class UserController extends Controller
{
    public function index(Request $request) {
        $query = User::orderBy('lastname');

        if ($request['trashed'] == 1) $query->withTrashed();
        if ($request['trashed'] == 2) $query->onlyTrashed();


        if ($request->has('onlysupervisors') && $request->onlysupervisors == 1) {
            //mi unisce users a model_has_roles
           
            // PROVARE A FARE CON SPATIE

            $query->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            //mi unisce model_has_roles a roles
                  ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                  //mi prende i record che hanno roles.name = Supervisore
                  ->where('roles.name', 'Supervisore')
                  // selezionia solo le colonne della tabella degli utenti
                  ->select('users.*'); 
                  //dd($query->get());
        }

        if ($request->has('project_id')) {  
            //prendo solo utenti che nella pivot hanno project_id uguale a quello nella request
            $project_id = $request->project_id;
            $query->join('project_user', 'users.id', '=', 'project_user.user_id')
                  ->where('project_user.project_id', $project_id);

                  // TODO PROVARE A FARE CON RELAZIONE E NON CON JOIN
        }
        

        return response()->json(UserResource::collection($query->get()));
        
    }

    public function store(UserRequest $request)
    {
        
        
        $user = User::create($request->all());
        $user->assignRole($request->get('role'));

        // questo sync funziona se non c'è il campo "projects[]" nella request
        // non funziona però se questo campo è presente ma vuoto.
        // da capire come gestirla quando arriveremo al frontend.
        $user->projects()->sync($request->get('projects'));

        return response()->json(new UserResource($user->load('projects')));
    }

    public function show(Request $request, User $user) {
        return response()->json(new UserResource($user->load('projects')));
    }

    public function delete(User $user)
    {
        return $user->delete() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }


    public function restore($id)
    {
        return User::withTrashed()->find($id)->restore() ? 
        response()->json(['error' => 'false']) :
        response()->json(['error' => 'true']);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return response()->json(new UserResource($user));
    }

    public function sendPassword(Request $request, User $user)
    {
        $password = Str::upper(Str::random(8));
        $user->update(['password' => Hash::make($password)]);
        Mail::to($user->email)->send(new SendPassword($user, $password, $request->get('software')));
        return response()->json(['success' => true], 200);
    }
    
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8'
        ],[
            'password.required' => 'Il campo password è obbligatorio.',
            'password.confirmed' => 'Le password non corrispondono.',
            'password.min' => 'La password deve contenere almeno :min caratteri.',
        ]);
        $user->update(['password' => Hash::make($request->get('password'))]);
        return response()->json(new UserResource($user));
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}