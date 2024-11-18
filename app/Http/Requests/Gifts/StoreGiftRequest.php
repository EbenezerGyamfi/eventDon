<?php

namespace App\Http\Requests\Gifts;

use Illuminate\Foundation\Http\FormRequest;

class StoreGiftRequest extends FormRequest
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

    public function attributes()
    {
        return [
            'type.required' => 'gift type',
            'name.required_if' => 'item name',
            'attendee_id.required' => 'donor',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_id' => ['required', 'numeric'],
            'type' => ['required', 'in:wrapped parcel,unwrapped parcel'],
            'name' => ['required_if:type,==,unwrapped parcel', 'max:100'],
            'quantity' => ['numeric', 'required', 'gte:1'],
            'description' => ['nullable'],
            'attendee_id' => ['required', 'numeric'],
            //            'received_by' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'The :attribute must be either Wrapped Parcel or Unwrapped Parcel',
            'name.required_if' => ':attribute is required if Unwrapped Parcel is selected',
        ];
    }
}
