<?php

namespace App\Http\Controllers;

use Gate;

class DataController extends Controller
{
    public function open()
    {
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('data'), 200);

    }

    public function closed()
    {
        print_r(Gate::allows('isCompanyNormal'));
        if (!Gate::allows('isCompanyNormal')) {
            $data = "Only authorized users can see this";
            return response()->json(compact('data'), 200);
        }
        return response()->json(['message' => 'Not permission to access this api'], 403);
    }
}
