<?php

namespace App\Http\Requests\UssdExtension;

use Illuminate\Foundation\Http\FormRequest;

class StoreUssdExtensionRequest extends FormRequest
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
            'code' => 'required|string|unique:ussd_extensions|regex:/^\*[0-9\*#]*[0-9]+[0-9\*#]*#$/',
        ];
    }
}
