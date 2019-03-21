<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 12/12/2018
 * Time: 6:50 PM
 */

namespace App\Repositories\TB_DASHBOARDS;

use App\TB_DASHBOARDS;
use Auth;
use DB;

class EloquentDashboards implements DashboardsRepository
{

    public function getAllDashboard()
    {
        // TODO: Implement getAllDashboard() method.
        if (Auth::user()->type_user == 'CUSTOMER') {
            $data = DB::table('TB_DASHBOARDS')->where(
                'TB_USERS.user_id', Auth::user()->user_id
            )
                ->join('TB_USERS', 'TB_USERS.user_id', '=', 'TB_DASHBOARDS.user_id')
                ->get(['TB_DASHBOARDS.dashboard_id', 'TB_DASHBOARDS.description', 'TB_DASHBOARDS.name', 'TB_USERS.fname', 'TB_USERS.lname']);
        } else {
            $data = DB::table('TB_DASHBOARDS')->where(
                'TB_USER_COMPANY.company_id', Auth::user()->user_company()->first()->company_id
            )
                ->join('TB_USERS', 'TB_USERS.user_id', '=', 'TB_DASHBOARDS.user_id')
                ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_USERS.user_id')
                ->get(['TB_DASHBOARDS.dashboard_id', 'TB_DASHBOARDS.is_public', 'TB_DASHBOARDS.description', 'TB_DASHBOARDS.name', 'TB_USERS.fname', 'TB_USERS.lname']);
        }
        return response()->json(compact('data'), 200);
    }

    public function getAllPublicDashboard($start = null, $length = null, $search = "")
    {
        $data = DB::table('TB_DASHBOARDS')->where(
            [
                ['TB_DASHBOARDS.is_public', '=', true],
                ['TB_DASHBOARDS.name', 'LIKE', "%{$search}%"],
            ]
        )

            ->offset($start)
            ->limit($length)
            ->get(['dashboard_id', 'description', 'name']);

        $out['dashboards'] = $data;
        $out['total'] = DB::table('TB_DASHBOARDS')->where([
            ['TB_DASHBOARDS.is_public', '=', true],
        ])->count();

        return $out;
    }

    public function getDashboardById($dashboard_id)
    {
        // TODO: Implement getDashboardById() method.
        if (Auth::user()->type_user == 'CUSTOMER') {
            $data = TB_DASHBOARDS::where([
                ['TB_USERS.user_id', Auth::user()->user_id],
                ['TB_DASHBOARDS.dashboard_id', $dashboard_id],
            ])
                ->join('TB_USERS', 'TB_USERS.user_id', '=', 'TB_DASHBOARDS.user_id')
                ->get(['TB_DASHBOARDS.dashboard_id', 'TB_DASHBOARDS.name', 'TB_DASHBOARDS.dashboard']);
        } else {
            $data = TB_DASHBOARDS::where([
                ['TB_USER_COMPANY.company_id', Auth::user()->user_company()->first()->company_id],
                ['TB_DASHBOARDS.dashboard_id', $dashboard_id],
            ])
                ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_DASHBOARDS.user_id')
                ->get(['TB_DASHBOARDS.dashboard_id', 'TB_DASHBOARDS.name', 'TB_DASHBOARDS.dashboard']);
        }
        return response()->json(compact('data'), 200);
    }

    public function getDashboardPublicById($dashboard_id)
    {
        $data = DB::table('TB_DASHBOARDS')->where(
            [
                ['TB_DASHBOARDS.is_public', '=', true],
                ['TB_DASHBOARDS.dashboard_id', '=', $dashboard_id],
            ]
        )->first();

        return $data;
    }

    public function createDashboard($attr)
    {
        // TODO: Implement createDashboard() method.
        if (is_null($attr['is_public'])) {
            $attr['is_public'] = false;
        }

        DB::beginTransaction();
        try {
            $data = TB_DASHBOARDS::create([
                'name' => $attr['name'],
                'description' => $attr['description'],
                'user_id' => Auth::user()->user_id,
                'is_public' => $attr['is_public'],
                'dashboard' => '[]',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return response()->json(["status", "success"], 201);
    }

    public function updateDashboardLayout($dashboard_id, $layout)
    {
        DB::beginTransaction();
        try {
            TB_DASHBOARDS::where([
                ['dashboard_id', '=', $dashboard_id],
            ])->update(['dashboard' => $layout]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function updateDashboard($dashboard_id, $name, $desc, $is_public = false)
    {
        // TODO: Implement updateDashboard() method.
        DB::beginTransaction();
        try {
            if (Auth::user()->type_user == 'CUSTOMER') {
                $checkData = DB::table('TB_DASHBOARDS')->where([
                    ['TB_DASHBOARDS.dashboard_id', '=', $dashboard_id],
                    ['TB_USERS.user_id', '=', Auth::user()->user_id],
                ])
                    ->join('TB_USERS', 'TB_USERS.user_id', '=', 'TB_DASHBOARDS.user_id')
                    ->get();
            } else {
                $checkData = DB::table('TB_DASHBOARDS')->where([
                    ['TB_DASHBOARDS.dashboard_id', '=', $dashboard_id],
                    ['TB_USER_COMPANY.company_id', '=', Auth::user()->user_company()->first()->company_id],
                ])
                    ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_DASHBOARDS.user_id')
                    ->get();
            }

            if (is_null($is_public)) {
                $is_public = false;
            }

            if (!empty($checkData)) {
                TB_DASHBOARDS::where([
                    ['dashboard_id', '=', $dashboard_id],
                ])->update([
                    'name' => $name,
                    'description' => $desc,
                    'is_public' => $is_public,
                ]);
            } else {
                return response()->json(["status", "Can not edit this dashboard"], 201);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return response()->json(["status", "success"], 201);
    }

    public function deleteDashboard($dashboard_id)
    {
        // TODO: Implement deleteDashboard() method.
        DB::beginTransaction();
        try {
            if (Auth::user()->type_user == 'CUSTOMER') {
                DB::table('TB_DASHBOARDS')->where([
                    ['TB_DASHBOARDS.dashboard_id', '=', $dashboard_id],
                    ['TB_USERS.user_id', '=', Auth::user()->user_id],
                ])
                    ->join('TB_USERS', 'TB_USERS.user_id', '=', 'TB_DASHBOARDS.user_id')
                    ->delete();
            } else {
                DB::table('TB_DASHBOARDS')->where([
                    ['TB_DASHBOARDS.dashboard_id', '=', $dashboard_id],
                    ['TB_USER_COMPANY.company_id', '=', Auth::user()->user_company()->first()->company_id],
                ])
                    ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_DASHBOARDS.user_id')
                    ->delete();
            }

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return response()->json(["status", "success"], 201);
    }
}
