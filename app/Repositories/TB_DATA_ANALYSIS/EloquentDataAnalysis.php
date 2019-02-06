<?php

namespace App\Repositories\TB_DATA_ANALYSIS;

use App\Jobs\PrepareDataAnalysis;
use App\TB_DATA_ANALYSIS;
use Auth;
use DB;

class EloquentDataAnalysis implements DataAnalysisRepository
{

    public function getAll()
    {
        $data = TB_DATA_ANALYSIS::all();
        return $data;
    }

    public function getByCompany()
    {
        $data = TB_DATA_ANALYSIS::where([
            ['TB_USER_COMPANY.company_id', '=', Auth::user()->user_company()->first()->company_id],
        ])
            ->join('TB_USERS', 'TB_USERS.user_id', '=', 'TB_DATA_ANALYSIS.user_id')
            ->join('TB_USER_COMPANY', 'TB_USER_COMPANY.user_id', '=', 'TB_USERS.user_id')
            ->get(['TB_DATA_ANALYSIS.data_id', 'TB_DATA_ANALYSIS.name', 'TB_DATA_ANALYSIS.is_success',
                'TB_USERS.user_id', 'TB_USERS.fname', 'TB_USERS.lname',
            ]);
        return $data;
    }

    public function getById($data_id)
    {
        $data = TB_DATA_ANALYSIS::where([
            ['data_id', '=', $data_id],
            ['user_id', '=', Auth::user()->user_id],
        ]);
        return $data;
    }

    public function create(array $attr)
    {
        DB::beginTransaction();
        try {
            $data = TB_DATA_ANALYSIS::create([
                'user_id' => Auth::user()->user_id,
                'name' => $attr['name'],
            ]);
            // $convert = new ConvertJsonToArff();
            // $convert->convertToAttr($attr['pathArray'], $attr['name'], $data->data_id);
            dispatch(new PrepareDataAnalysis($data->data_id, $attr['pathArray'], $attr['name']));
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function delete($data_id, $user_id)
    {
        DB::beginTransaction();
        try {
            $data = TB_DATA_ANALYSIS::where([
                ['data_id', '=', $data_id],
                ['user_id', '=', $user_id],
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

}
