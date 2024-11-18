<?php

namespace App\Http\Requests;

use App\Rules\IsPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class CustomerInquiryRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'string',
                'email',
            ],
            'phone' => [
                'required',
                'string',
                new IsPhoneNumber,
            ],
            'message' => [
                'required',
                'string',
            ],
        ];
    }
}
