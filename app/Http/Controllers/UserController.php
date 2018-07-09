<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function add(Request $request)
    {
       $users = new Users;
       $name = $request->input('name');
       $username = $request->input('username');

       return response()->json($users->add($name, $username));
    }

    public function delete(Request $request)
    {
        $users = new Users;
        $username = $request->input('username');

        return response()->json($users->remove($username));
    }

    public function list()
    {
        $users = new Users;
        return response()->json($users->list());
    }

    public function show()
    {
        return view('welcome');
    }

    public function change(Request $request)
    {
        $users = new Users;
        $username = $request->input('username');
        $newusername = $request->input('newusername');
        return response()->json($users->change($username, $newusername));
    }
}