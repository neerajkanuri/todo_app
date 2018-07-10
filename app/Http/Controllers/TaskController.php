<?php

namespace App\Http\Controllers;

use App\Tasks;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function add(Request $request)
    {
        $tasks = new Tasks;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $description = $request->input('task');
        $x = $tasks->add($username, $listname, $description);
        return response()->json($x[0],$x[1]);
    }

    public function delete(Request $request)
    {
        $tasks = new Tasks;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $description = $request->input('task');
        $x = $tasks->remove($username, $listname, $description);
        return response()->json($x[0],$x[1]);
    }

    public function list($username, $listname)
    {
        $tasks = new Tasks;
        $x = $tasks->list($username, $listname);
        return response()->json($x[0],$x[1]);

    }

    public function change(Request $request)
    {
        $tasks = new Tasks;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $description = $request->input('task');
        $newdescription = $request->input('newtask');
        $x = $tasks->change($username, $listname, $description,$newdescription);
        return response()->json($x[0],$x[1]);
    }
}
