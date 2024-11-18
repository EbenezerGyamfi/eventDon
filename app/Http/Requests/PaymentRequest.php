<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
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
            'amount' => ['required'],
            'currency' => ['required', 'string'],
            'channel' => ['required', 'string', Rule::in(['mobile_money', 'bank', 'card'])],
            'itemId' => ['required', 'numeric', 'exists:wallets,id'],
            'account_number' => ['required_if:channel,mobile_money'],
            'provider' => ['required_if:channel,mobile_money', Rule::in(['mtn', 'airteltigo', 'vodafone'])],
        ];
    }
}
