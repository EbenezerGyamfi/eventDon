<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
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
            'no_phone' => ['required', 'boolean'],
            'attendee_id' => ['required_if:no_phone,false', 'exists:attendees,id'],
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'no_phone' => $this->boolean('no_phone'),
        ]);
    }
}
