<?php

namespace App\Http\Controllers;

use App\Lists;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function add(Request $request)
    {
        $lists = new Lists;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $x = $lists->add($username, $listname);
        return response()->json($x[0],$x[1]);
    }

    public function delete(Request $request)
    {
        $lists = new Lists;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $x = $lists->remove($username, $listname);
        return response()->json($x[0],$x[1]);
    }

    public function show($username)
    {
        $lists = new Lists;
        $x = $lists->show($username);
        return response()->json($x[0],$x[1]);
    }

    public function change(Request $request)
    {
        $lists = new Lists;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $newlistname = $request->input('newlistname');
        $x = $lists->change($username, $listname, $newlistname);
        return response()->json($x[0],$x[1]);
    }
}

