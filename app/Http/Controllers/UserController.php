<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function add(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'username' => 'required|max:255',
            ]);
        }

        catch(\Exception $e)
        {
            return response()->json($this->getErrorJson($e->getMessage(), [
                'field' => 'name',
            ]),400);
        }

       $users = new Users;
       $name = $request->input('name');
       $username = $request->input('username');


       $x = $users->add($name, $username);
       return response()->json($x[0],$x[1]);
    }

    protected function getErrorJson(string $message, array $data = [])
    {
        return [
            'message' => $message,
            'data'    => $data,
        ];
    }

    public function delete(Request $request)
    {
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
        $users = new Users;
        $username = $request->input('username');
        $newusername = $request->input('newusername');
        $x = $users->change($username, $newusername);
        return response()->json($x[0],$x[1]);
    }
}