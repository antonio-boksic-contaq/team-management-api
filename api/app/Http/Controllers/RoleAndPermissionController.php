<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use DB;

class RoleAndPermissionController extends Controller
{
    public function all(){
        return DB::table('roles')->select('name as id','name')->orderBy('name')->get();
    }
}