<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class InfographicController extends Controller
{
    public function Index()
    {
        return view('Infographic.Index')->with('user', Auth::user());
    }

    public function CustomInfographic($id, $keyfilename)
    {
        return view('Infographic.CustomInfographic')
            ->with('id', $id)
            ->with('keyfilename', $keyfilename)
            ->with('user', Auth::user());
    }
}
