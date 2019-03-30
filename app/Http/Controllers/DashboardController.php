<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Index(Request $request)
    {
        $user = $request->session()->get('user');
        if ($user->type_user === "COMPANY") {
            return view('Dashboard.Index_For_Company');
        } else {
            return view('Dashboard.Index');
        }
    }

    public function DashboardsPublic()
    {
        return view('Dashboard.DashboardsPublic');
    }

    public function DashboardsPublicId($id)
    {
        return view('Dashboard.DashboardsPublicId')
            ->with('id', $id);

    }

    public function CustomDashboard(Request $request, $id, $edit_type = "", $user_id = "Me")
    {

        return view('Dashboard.CustomDashboard')
            ->with('id', $id)
            ->with('edit_type', $edit_type)
            ->with('user_id', $user_id);
    }
}
