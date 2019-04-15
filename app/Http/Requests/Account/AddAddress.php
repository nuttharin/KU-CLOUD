<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\FormRequest;

class AddAddress extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "address_detail" => "required|max:200",
            "district_id" => "required",
            "amphure_id" => "required",
            "province_id" => "required",
        ];
    }
}
