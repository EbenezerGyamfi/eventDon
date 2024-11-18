<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketTypeRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:50',
                "regex:/^[^*|\":<>[\]{}`\\()';@&$]+$/",
            ],
            'price' => [
                'required',
                'numeric',
                'min:0.5',
            ],
            'no_of_available_tickets' => [
                'required',
                'numeric',
                'gt:0',
            ],
        ];
    }
}
