<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/29/2018
 * Time: 10:21 AM
 */

namespace App\Repositories\TB_INFOGRAPHIC;

use Illuminate\Support\Facades\Hash;

use App\TB_INFOGRAPHIC;
use App\TB_USERS;
use App\TB_INFO_DATASOURCE;

use DB;
use Log;

class EloquentInfographic implements InfographicRepository
{
    /**
     * EloquentUsers constructor.
     * @param TB_INFOGRAPHIC $model
     */
    public function __construct(TB_INFOGRAPHIC $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function getInfographicByUserID($user_id)
    {
        $data = [];

        $infoDataList = $this->model::where('user_id', $user_id)->get();

        foreach($infoDataList as $infoData ){ 
            $data[] = [
                'info_id'=>$infoData->info_id,
                'user_id'=>$infoData->user_id,
                'name'=>$infoData->name,
                'info_data'=>$infoData->info_data,
                'created_by'=>$infoData->created_by,
                'updated_by'=>$infoData->updated_by,
                'created_at'=>$infoData->create_at,
                'updated_at'=>$infoData->updated_at,
            ];
        }

        return $data;
    }

    public function getInfographicByInfoID($info_id)
    {
        $infoDataList = $this->model::where('info_id', $info_id)->first();

        return $infoDataList;
    }

    public function createInfoDatasource(array  $attr)
    {
        TB_INFO_DATASOURCE::create($attr);
    }

    public function getInfoDatasourceByInfoID($info_id)
    {
        $infoDataList = TB_INFO_DATASOURCE::join('TB_WEBSERVICE', 'TB_WEBSERVICE.webservice_id', '=', 'TB_INFO_DATASOURCE.webservice_id')->where('info_id', $info_id)->select('TB_INFO_DATASOURCE.*', 'TB_WEBSERVICE.value_cal')->get();

        return $infoDataList;
    }

    //Custom function
    public function getInfographicByCompanyId($user_id, $company_id)
    {
        $data = [];

        $infoDataList = $this->model::join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_INFOGRAPHIC.user_id')
                                        ->where([
                                                    ['TB_USER_COMPANY.company_id', '=', $company_id]
                                                ])
                                        ->select('TB_INFOGRAPHIC.*')
                                        ->get();

        foreach($infoDataList as $infoData ){ 
            $data[] = [
                'info_id'=>$infoData->info_id,
                'user_id'=>$infoData->user_id,
                'name'=>$infoData->name,
                'info_data'=>$infoData->info_data,
                'created_by'=>$infoData->created_by,
                'updated_by'=>$infoData->updated_by,
                'created_at'=>$infoData->create_at,
                'updated_at'=>$infoData->updated_at,
            ];
        }

        return $data;
    }



}