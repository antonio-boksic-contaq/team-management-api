<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendPassword;

class UserController extends Controller
{
    public function index() {
        $query = User::orderBy('lastname');
        return response()->json(UserResource::collection($query->get()));
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        return response()->json(new UserResource($user));
    }

    public function show(Request $request, User $user) {
        return response()->json(new UserResource($user->load('team')));

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

}