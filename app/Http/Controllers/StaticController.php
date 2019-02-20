<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StaticController extends Controller
{

    public function Index()
    {
        return view('Static.Index')->with('user', Auth::user());
    }

    public function CustomStatic($id)
    {
        return view('Static.CustomStatic')
            ->with('id', $id)
            ->with('user', Auth::user());
    }

}
