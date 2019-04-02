<?php
/**
 * Created by PhpStorm.
 * User: TEAM
 * Date: 10/30/2018
 * Time: 8:48 PM
 */

namespace App\Repositories\TB_COMPANY;

use App\Address_company;
use App\LogViewer\SizeLog;
use App\TB_COMPANY;
use App\TB_USER_CUSTOMER;
use Auth;
use Illuminate\Support\Facades\DB;
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
        try {
            $company = DB::select('SELECT TB_COMPANY.company_id, TB_COMPANY.img_logo,TB_COMPANY.company_name, alias, note,
                                        ADDRESS_COMPANY.address_detail, ADDRESS_COMPANY.district_id, ADDRESS_COMPANY.amphure_id, ADDRESS_COMPANY.province_id,
                                        DISTRICTS.zip_code, DISTRICTS.name_th as dNameTh, DISTRICTS.name_en as dNameEn,
                                        AMPHURES.name_th as aNameTh, AMPHURES.name_en as aNameEn,
                                        PROVINCES.name_th as pNameTh, PROVINCES.name_en as pNameEn
                                FROM TB_COMPANY INNER JOIN ADDRESS_COMPANY ON ADDRESS_COMPANY.company_id = TB_COMPANY.company_id
                                INNER JOIN DISTRICTS ON DISTRICTS.district_id = ADDRESS_COMPANY.district_id
                                INNER JOIN AMPHURES ON AMPHURES.amphure_id = ADDRESS_COMPANY.amphure_id
                                INNER JOIN PROVINCES ON PROVINCES.province_id = ADDRESS_COMPANY.province_id
                                WHERE TB_COMPANY.company_id = ?', [$id])[0];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return;
        }
        return $company;
    }

    public function updateCompanyId(array $attr, $id)
    {
        DB::beginTransaction();
        try {
            $company = TB_COMPANY::where('company_id', $id)
                ->update([
                    'company_name' => $attr['company_name_input'],
                    'alias' => $attr['alias_input'],
                    'note' => $attr['note_input'],
                ]);

            $address_company = Address_company::where('company_id', $id)
                ->update([
                    'address_detail' => $attr['address_detail'],
                    'district_id' => $attr['district'],
                    'amphure_id' => $attr['amphure'],
                    'province_id' => $attr['province'],
                ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
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

    public function getCompanyWithAddress()
    {
        $company_all = TB_COMPANY::all();
        $company_list = [];
        foreach ($company_all as $value) {
            $company_list[] = [
                'company_id' => $value->company_id,
                'company_name' => $value->company_name,
                'img_logo' => config('app.API_URL') . 'company/logo/'.$value->img_logo,
                'alias' => $value->alias,
                'note' => $value->note,
                'address' => DB::select('SELECT ADDRESS_COMPANY.company_id, ADDRESS_COMPANY.address_detail, ADDRESS_COMPANY.district_id, ADDRESS_COMPANY.amphure_id, ADDRESS_COMPANY.province_id,
                                                    DISTRICTS.zip_code, DISTRICTS.name_th as dNameTh, DISTRICTS.name_en as dNameEn,
                                                    AMPHURES.name_th as aNameTh, AMPHURES.name_en as aNameEn,
                                                    PROVINCES.name_th as pNameTh, PROVINCES.name_en as pNameEn
                                            FROM ADDRESS_COMPANY INNER JOIN DISTRICTS ON DISTRICTS.district_id = ADDRESS_COMPANY.district_id
                                            INNER JOIN AMPHURES ON AMPHURES.amphure_id = ADDRESS_COMPANY.amphure_id
                                            INNER JOIN PROVINCES ON PROVINCES.province_id = ADDRESS_COMPANY.province_id
                                            WHERE ADDRESS_COMPANY.company_id = ?', [$value->company_id]),
            ];
        }
        return $company_list;
    }
}
