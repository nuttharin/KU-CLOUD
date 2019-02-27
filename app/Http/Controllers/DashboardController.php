<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Index(Request $request)
    {
        return view('Dashboard.Index');
    }

    public function CustomDashboard(Request $request, $id)
    {
        return view('Dashboard.CustomDashboard')
            ->with('id', $id);
    }
}
