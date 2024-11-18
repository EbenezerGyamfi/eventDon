<?php

namespace App\Http\Requests\UssdExtension;

use App\Rules\UssdCodeNotInUse;
use Illuminate\Foundation\Http\FormRequest;

class DeleteUssdRequest extends FormRequest
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
            'code' => ['required', 'exists:ussd_extension', new UssdCodeNotInUse],
        ];
    }
}
