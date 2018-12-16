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
use App\TB_STATIC_COMPANY;
use DB;

class EloquentStatic implements StaticRepository
{

    public function getStaticByCompanyId($company_id)
    {
        // TODO: Implement getStaticByCompanyId() method.
        $data = DB::select("SELECT TB_STATIC.static_id, TB_STATIC.name FROM TB_STATIC
                            INNER JOIN TB_STATIC_COMPANY ON TB_STATIC_COMPANY.static_id = TB_STATIC.static_id
                            WHERE TB_STATIC_COMPANY.company_id = ?", [$company_id]);

        return $data;
    }

    public function createStatic($name,$company_id)
    {
        // TODO: Implement createStatic() method.
        DB::beginTransaction();
        try{
            $data =  TB_STATIC::create([
                'name'=>$name,
                'dashboard'=>$company_id,
            ]);

            if(!empty($data)){
                TB_STATIC_COMPANY::insert([
                    'static_id'=>$data->static_id,
                    'company_id'=>$company_id,
                ]);
            }
        }
        catch(Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return [
            'status' => 201,
            'message' => 'success',
        ];
    }

    public function updateStatic($static_id,$name,$company_id)
    {
        // TODO: Implement updateStatic() method.
        try {
            $checkData = TB_STATIC_COMPANY::where([
                ['static_id', '=', $static_id],
                ['company_id', '=', $company_id]
            ])->get();

            if (!empty($checkData)) {
                TB_STATIC::where([
                    ['static_id', '=', $static_id],
                ])->update(['name' => $name]);
            } else {
                return response()->json(["status", "Can not edit this static"], 201);
            }
        }
        catch(Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return response()->json(["status","success"],201);
    }

    public function deleteStatic($static_id,$company_id)
    {
        // TODO: Implement deleteStatic() method.
        try{
            TB_STATIC_COMPANY::where([
                ['static_id','=',$static_id],
                ['company_id','=',$company_id]
            ])->delete();


        }
        catch(Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return response()->json(["status","success"],201);
    }

    public function getStaticDashboardById($static_id,$company_id)
    {
        // TODO: Implement getStaticDashboardById() method.
        $data = DB::select("SELECT TB_STATIC.static_id, TB_STATIC.name,TB_STATIC.dashboard FROM TB_STATIC
                            INNER JOIN TB_STATIC_COMPANY ON TB_STATIC_COMPANY.static_id = TB_STATIC.static_id
                            WHERE TB_STATIC_COMPANY.company_id = ? AND TB_STATIC_COMPANY.static_id = ?", [$company_id,$static_id]);
        return $data;
    }

    public function updateDashboard(array $attr)
    {
        // TODO: Implement updateDashboard() method.

    }

    public function getDatasoureByStaticId($static_id,$company_id)
    {
         // TODO: Implement getDatasoureByStaticId() method.
        $data = DB::select("SELECT TB_STATIC_DATASOURCE.id,TB_STATIC_DATASOURCE.name,TB_STATIC_DATASOURCE.body,TB_STATIC_DATASOURCE.headers,TB_WEBSERVICE.URL
                            FROM TB_STATIC_COMPANY
                            INNER JOIN TB_STATIC_DATASOURCE ON TB_STATIC_DATASOURCE.static_id = TB_STATIC_COMPANY.static_id
                            INNER JOIN TB_WEBSERVICE ON TB_WEBSERVICE.webservice_id = TB_STATIC_DATASOURCE.webservice_id
                            WHERE TB_STATIC_COMPANY.static_id = ? AND TB_STATIC_COMPANY.company_id = ?",[$static_id,$company_id]);
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

    public function deleteDatasource(array $attr)
    {
        // TODO: Implement deleteDatasource() method.
    }
}