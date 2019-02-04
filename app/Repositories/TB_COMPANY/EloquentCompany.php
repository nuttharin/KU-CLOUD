<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/30/2018
 * Time: 8:48 PM
 */

namespace App\Repositories\TB_COMPANY;

use App\LogViewer\SizeLog;
use App\TB_COMPANY;
use App\TB_USER_CUSTOMER;
use Auth;
use Log;

class EloquentCompany implements CompanyRepository
{
    public function getAllCompany()
    {
        try {
            $company = TB_COMPANY::all()->paginate(15);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return;
        }
        return $company;
    }

    /**
     * @param $id
     */
    public function getCompanyById($id)
    {
        // TODO: Implement getCompanyById() method.
    }

    public function getCompanyList()
    {
        try {
            $company = TB_COMPANY::all();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return;
        }
        return $company;
    }

    public function getCompanyListForCustomer()
    {
        try {
            $company = TB_COMPANY::where([
                ['TB_USER_CUSTOMER.user_id', '=', Auth::user()->user_id],
            ])
                ->join('TB_USER_CUSTOMER', 'TB_USER_CUSTOMER.company_id', '=', 'TB_COMPANY.company_id')->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return;
        }
        return $company;
    }

    public function approveCompany($company_id)
    {
        try {
            $company = TB_USER_CUSTOMER::where([
                ['TB_USER_CUSTOMER.user_id', '=', Auth::user()->user_id],
                ['TB_USER_CUSTOMER.company_id', '=', $company_id],
            ])->update([
                'TB_USER_CUSTOMER.is_approved' => true,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return;
        }
    }

    public function getCompanyFolderLog()
    {
        try {
            $folder_log = TB_COMPANY::all();
            $folder_log_size = [];
            foreach ($folder_log as $key => $value) {
                $folder_log_size[] = [
                    'company_id' => $value->company_id,
                    'company_name' => $value->company_name,
                    'folder_log' => $value->folder_log,
                    'size' => SizeLog::getSizeFolder($value->folder_log),
                ];
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return $folder_log_size;
    }
}
