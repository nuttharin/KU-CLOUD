<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/30/2018
 * Time: 8:48 PM
 */

namespace App\Repositories\TB_COMPANY;

use Log;

use DB;
use App\TB_COMPANY;
use App\LogViewer\SizeLog;

class EloquentCompany implements CompanyRepository
{

    /**
     * @param $id
     */
    public function getCompanyById($id)
    {
        // TODO: Implement getCompanyById() method.
    }

    public function getCompanyList()
    {
        try{
            $company = TB_COMPANY::all();
        }
        catch (Exception $e){
            Log::error($e->getMessage());
            return;
        }
        return $company;
    }

    public function getCompanyFolderLog()
    {
        try {
            $folder_log = TB_COMPANY::all();
            $folder_log_size = [];
            foreach ($folder_log as $key=>$value){
                $folder_log_size[] = [
                    'company_id'=>$value->company_id,
                    'company_name'=>$value->company_name,
                    'folder_log'=>$value->folder_log,
                    'size'=>SizeLog::getSizeFolder($value->folder_log),
                ];
            }
        }
        catch (Exception $e){
            Log::error($e->getMessage());
        }
        return $folder_log_size;
    }
}