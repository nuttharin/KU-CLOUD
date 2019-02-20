<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 12/12/2018
 * Time: 6:50 PM
 */

namespace App\Repositories\TB_STATIC;

use App\TB_STATIC;
use App\TB_STATIC_DATASOURCE;
use Auth;
use DB;

class EloquentStatic implements StaticRepository
{

    public function getStaticByCompanyId($company_id)
    {
        // TODO: Implement getStaticByCompanyId() method.
        $data = DB::table('TB_STATIC')->where(
            'TB_USER_COMPANY.company_id', $company_id
        )
            ->join('TB_USERS', 'TB_USERS.user_id', '=', 'TB_STATIC.user_id')
            ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_USERS.user_id')
            ->get(['TB_STATIC.static_id', 'TB_STATIC.name', 'TB_USERS.fname', 'TB_USERS.lname']);

        return $data;
    }

    public function createStatic($name)
    {
        // TODO: Implement createStatic() method.
        DB::beginTransaction();
        try {
            $data = TB_STATIC::create([
                'name' => $name,
                'user_id' => Auth::user()->user_id,
                'dashboard' => '{}',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return [
            'status' => 201,
            'message' => 'success',
        ];
    }

    public function updateStatic($static_id, $name, $company_id)
    {
        // TODO: Implement updateStatic() method.
        try {
            $checkData = DB::table('TB_STATIC')->where([
                ['TB_STATIC.static_id', '=', $static_id],
                ['TB_USER_COMPANY.company_id', '=', $company_id],
            ])
                ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_STATIC.user_id')
                ->get();

            if (!empty($checkData)) {
                TB_STATIC::where([
                    ['static_id', '=', $static_id],
                ])->update(['name' => $name]);
            } else {
                return response()->json(["status", "Can not edit this static"], 201);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return response()->json(["status", "success"], 201);
    }

    public function deleteStatic($static_id, $company_id)
    {
        // TODO: Implement deleteStatic() method.
        try {
            DB::table('TB_STATIC')->where([
                ['TB_STATIC.static_id', '=', $static_id],
                ['TB_USER_COMPANY.company_id', '=', $company_id],
            ])
                ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_STATIC.user_id')
                ->delete();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return response()->json(["status", "success"], 201);
    }

    public function getStaticDashboardById($static_id, $company_id)
    {
        // TODO: Implement getStaticDashboardById() method.
        $data = TB_STATIC::where([
            ['TB_USER_COMPANY.company_id', $company_id],
            ['TB_STATIC.static_id', $static_id],
        ])
            ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_STATIC.user_id')
            ->get(['TB_STATIC.static_id', 'TB_STATIC.name', 'TB_STATIC.dashboard']);
        return $data;
    }

    public function updateDashboard(array $attr)
    {
        // TODO: Implement updateDashboard() method.

    }

    public function getDatasoureByStaticId($static_id, $company_id)
    {
        // TODO: Implement getDatasoureByStaticId() method.
        $data = TB_STATIC::where([
            ['TB_USER_COMPANY.company_id', $company_id],
            ['TB_STATIC.static_id', $static_id],
        ])
            ->join('TB_STATIC_DATASOURCE', 'TB_STATIC_DATASOURCE.static_id', '=', 'TB_STATIC.static_id')
            ->join('TB_WEBSERVICE', 'TB_WEBSERVICE.webservice_id', '=', 'TB_STATIC_DATASOURCE.webservice_id')
            ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_STATIC.user_id')
            ->get(['TB_STATIC_DATASOURCE.id', 'TB_STATIC_DATASOURCE.name', 'TB_WEBSERVICE.webservice_id', 'TB_STATIC_DATASOURCE.timeInterval', 'TB_STATIC_DATASOURCE.body', 'TB_STATIC_DATASOURCE.headers', 'TB_WEBSERVICE.URL']);
        return $data;
    }

    public function createDatasource(array $attr)
    {
        // TODO: Implement createDatasource() method.
        TB_STATIC_DATASOURCE::create($attr);
    }

    public function updateDatasource(array $attr)
    {
        // TODO: Implement updateDatasource() method.
    }

    public function deleteDatasourceByStatic($static_id, $id)
    {
        // TODO: Implement deleteDatasource() method.
        DB::beginTransaction();
        try {
            $data = TB_STATIC_DATASOURCE::where([
                ['static_id', $static_id],
                ['id', $id],
            ])->delete();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }
}
