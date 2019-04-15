<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\FormRequest;

class ChangePassword extends FormRequest
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
            "new_password" => "required",
            "old_password" => "required",
        ];
    }
}
