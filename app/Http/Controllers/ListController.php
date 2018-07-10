<?php

namespace App\Http\Controllers;

use App\Lists;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function add(Request $request)
    {
        $basecontrol = new BaseController;
        $validcheck = $basecontrol->myvalidation($request,[
            'username' => 'required|max:255',
            'listname' => 'required|max:255',
        ]);

        if(isset($validcheck))
        {
            return response()->json($validcheck,400);
        }

        $lists = new Lists;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $x = $lists->add($username, $listname);
        return response()->json($x[0],$x[1]);
    }

    public function delete(Request $request)
    {
        $basecontrol = new BaseController;
        $validcheck = $basecontrol->myvalidation($request,[
            'username' => 'required|max:255',
            'listname' => 'required|max:255',
        ]);

        if(isset($validcheck))
        {
            return response()->json($validcheck,400);
        }

        $lists = new Lists;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $x = $lists->remove($username, $listname);
        return response()->json($x[0],$x[1]);
    }

    public function show($username)
    {
        if(strlen($username)>255)
        {
            return response()->json(['Error' => 'username is more than 255 characters'],400);
        }

        $lists = new Lists;
        $x = $lists->show($username);
        return response()->json($x[0],$x[1]);
    }

    public function change(Request $request)
    {
        $basecontrol = new BaseController;
        $validcheck = $basecontrol->myvalidation($request,[
            'username' => 'required|max:255',
            'listname' => 'required|max:255',
            'newlistname' => 'required|max:255',
        ]);

        if(isset($validcheck)) {
            return response()->json($validcheck, 400);
        }

        $lists = new Lists;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $newlistname = $request->input('newlistname');
        $x = $lists->change($username, $listname, $newlistname);
        return response()->json($x[0],$x[1]);
    }
}

