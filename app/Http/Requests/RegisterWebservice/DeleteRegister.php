<?php

namespace App\Http\Requests\RegisterWebservice;

use App\Http\Requests\FormRequest;

class DeleteRegister extends FormRequest
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
            "user_id" => "required",
            "register_webservice_id" => "required",
        ];
    }
}
