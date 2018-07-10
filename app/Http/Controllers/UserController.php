<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class UserController extends Controller
{
    public function add(Request $request)
    {
        $basecontrol = new BaseController;
        $validcheck = $basecontrol->myvalidation($request,[
            'name' => 'required|max:255',
            'username' => 'required|max:255',
        ]);

        if(isset($validcheck))
        {
            return response()->json($validcheck,400);
        }

       $users = new Users;
       $name = $request->input('name');
       $username = $request->input('username');


       $x = $users->add($name, $username);
       return response()->json($x[0],$x[1]);
    }



    public function delete(Request $request)
    {
        $basecontrol = new BaseController;
        $validcheck = $basecontrol->myvalidation($request,[
            'username' => 'required|max:255',
        ]);

        if(isset($validcheck))
        {
            return response()->json($validcheck,400);
        }

        $users = new Users;
        $username = $request->input('username');

        $x = $users->remove($username);
        return response()->json($x[0],$x[1]);
    }

    public function list()
    {
        $users = new Users;

        $x = $users->list();
        return response()->json($x[0],$x[1]);
    }

    public function show()
    {
        return view('welcome');
    }

    public function change(Request $request)
    {
        $basecontrol = new BaseController;
        $validcheck = $basecontrol->myvalidation($request,[
            'username' => 'required|max:255',
            'newusername' => 'required|max:255',
        ]);

        if(isset($validcheck))
        {
            return response()->json($validcheck,400);
        }

        $users = new Users;
        $username = $request->input('username');
        $newusername = $request->input('newusername');
        $x = $users->change($username, $newusername);
        return response()->json($x[0],$x[1]);
    }
}