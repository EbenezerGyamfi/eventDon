<?php

namespace App\Http\Requests\UssdExtension;

use App\Rules\IsNotReserved;
use Illuminate\Foundation\Http\FormRequest;

class CheckUssdRequest extends FormRequest
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
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date'],
            'code' => ['required', 'exists:ussd_extensions', new IsNotReserved($this->start_time, $this->end_time)],
        ];
    }
}
