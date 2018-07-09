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

        return response()->json($tasks->add($username, $listname, $description));
    }

    public function delete(Request $request)
    {
        $tasks = new Tasks;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $description = $request->input('task');

        return response()->json($tasks->remove($username, $listname, $description));
    }

    public function list($username, $listname)
    {
        $tasks = new Tasks;

        return response()->json($tasks->list($username, $listname));

    }

    public function change(Request $request)
    {
        $tasks = new Tasks;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $description = $request->input('task');
        $newdescription = $request->input('newtask');

        return response()->json($tasks->change($username, $listname, $description,$newdescription));
    }
}
