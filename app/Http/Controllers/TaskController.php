<?php

namespace App\Http\Controllers;

use App\Tasks;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function add(Request $request)
    {
        $basecontrol = new BaseController;
        $validcheck = $basecontrol->myvalidation($request,[
            'username' => 'required|max:255',
            'listname' => 'required|max:255',
            'task' => 'required|max:255',
        ]);

        if(isset($validcheck))
        {
            return response()->json($validcheck,400);
        }

        $tasks = new Tasks;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $description = $request->input('task');
        $x = $tasks->add($username, $listname, $description);
        return response()->json($x[0],$x[1]);
    }

    public function delete(Request $request)
    {
        $basecontrol = new BaseController;
        $validcheck = $basecontrol->myvalidation($request,[
            'username' => 'required|max:255',
            'listname' => 'required|max:255',
            'task' => 'required|max:255',
        ]);

        if(isset($validcheck))
        {
            return response()->json($validcheck,400);
        }

        $tasks = new Tasks;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $description = $request->input('task');
        $x = $tasks->remove($username, $listname, $description);
        return response()->json($x[0],$x[1]);
    }

    public function list($username, $listname)
    {
        if(strlen($username)>255)
        {
            return response()->json(['Error' => 'username is more than 255 characters'],400);
        }
        if(strlen($listname)>255)
        {
            return response()->json(['Error' => 'listname is more than 255 characters'],400);
        }

        $tasks = new Tasks;
        $x = $tasks->list($username, $listname);
        return response()->json($x[0],$x[1]);

    }

    public function change(Request $request)
    {
        $basecontrol = new BaseController;
        $validcheck = $basecontrol->myvalidation($request,[
            'username' => 'required|max:255',
            'listname' => 'required|max:255',
            'task' => 'required|max:255',
            'newtask' => 'required|max:255',
        ]);

        if(isset($validcheck))
        {
            return response()->json($validcheck,400);
        }

        $tasks = new Tasks;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $description = $request->input('task');
        $newdescription = $request->input('newtask');
        $x = $tasks->change($username, $listname, $description,$newdescription);
        return response()->json($x[0],$x[1]);
    }
}
