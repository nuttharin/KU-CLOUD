<?php

namespace App\Http\Controllers;

class InfographicController extends Controller
{
    public function Index()
    {
        $user = session('user');

        if($user->type_user == "COMPANY")
        {
            return view('Infographic.CompanyIndex');
        }
        else
        {
            return view('Infographic.Index');
        }
    }

    public function CustomInfographic($id, $keyfilename, $type_user)
    {
        $user = session('user');

        if($user->type_user == "COMPANY")
        {
            return view('Infographic.CustomInfographic')
            ->with('id', $id)
            ->with('keyfilename', $keyfilename)
            ->with('type_user', $type_user)
            ->with('company_id', $user->company_id);
        }
        else
        {
            return view('Infographic.CustomInfographic')
            ->with('id', $id)
            ->with('keyfilename', $keyfilename)
            ->with('type_user', $type_user)
            ->with('company_id', 0);
        }

    }
}
