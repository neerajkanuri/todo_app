<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
//    public function get($name)
//    {
//        $users = new Users;
//        return response()->json($users->getUser($name));
//    }

    public function addUser(Request $request)
    {
       $users = new Users;
       $name = $request->input('name');
       $username = $request->input('username');

       return response()->json($users->addUser($name, $username));
    }

    public function show()
    {
        return view('welcome');
    }
}