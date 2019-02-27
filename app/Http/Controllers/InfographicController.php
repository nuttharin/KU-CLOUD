<?php

namespace App\Http\Controllers;

class InfographicController extends Controller
{
    public function Index()
    {
        return view('Infographic.Index');
    }

    public function CustomInfographic($id)
    {
        return view('Infographic.CustomInfographic')
            ->with('id', $id);
    }
}
