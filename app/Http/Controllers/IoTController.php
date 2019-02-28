<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class IoTController extends Controller
{
    public function Iot()
    {
        //dd(Auth::user());
        return view('IoT.IoT')->with('user', Auth::user());
    }
}
