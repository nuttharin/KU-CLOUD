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


}