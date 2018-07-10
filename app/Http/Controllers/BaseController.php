<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class BaseController extends Controller
{
    public function myvalidation(Request $request,$a)
    {
        try {
            $request->validate($a);
        }

        catch(\Exception $e)
        {
            return $this->getErrorJson($e->getMessage());
        }
    }

    protected function getErrorJson(string $message, array $data = [])
    {
        return [
            'message' => $message,
//            'data'    => $data,
        ];
    }
}