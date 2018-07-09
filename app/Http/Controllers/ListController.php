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

        return response()->json($lists->add($username, $listname));
    }

    public function delete(Request $request)
    {
        $lists = new Lists;
        $username = $request->input('username');
        $listname = $request->input('listname');

        return response()->json($lists->remove($username, $listname));
    }

    public function show($username)
    {
        $lists = new Lists;
        return response()->json($lists->show($username));
    }

    public function change(Request $request)
    {
        $lists = new Lists;
        $username = $request->input('username');
        $listname = $request->input('listname');
        $newlistname = $request->input('newlistname');

        return response()->json($lists->change($username, $listname, $newlistname));
    }
}

