<?php

namespace App\Http\Requests\Accounts;

use App\Rules\IsPhoneNumber;
use App\Rules\IsUniqueAccountNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LVR\CreditCard\CardNumber;

class StoreAccountRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string',
            'type' => ['required', Rule::in(['mobile', 'bank', 'card', 'wallet'])],
        ];

        switch ($this->type) {
            case 'mobile':
                $rules = array_merge($rules, [
                    'network' => ['required', Rule::in(['mtn', 'vodafone', 'airteltigo'])],
                    'account_number' => ['bail', 'required', new IsPhoneNumber($this->network), new IsUniqueAccountNumber($this->type)],
                ]);
                break;

            case 'bank':
                $rules = array_merge($rules, [
                    'account_number' => ['required', 'numeric', 'digits_between:10,16', new IsUniqueAccountNumber($this->type)],
                    'bank_branch' => 'required|string',
                    'bank_name' => 'required|string',
                ]);
                break;

            case 'card':
                $rules = array_merge($rules, [
                    'account_number' => ['required', new IsUniqueAccountNumber($this->type), new CardNumber],
                    'card_type' => Rule::in(['visa', 'mastercard']),
                ]);
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'account_number.digits_between' => 'The account number must be between 10 and 16 digits long',
            'account_number.credit_card' => 'The card number entered is invalid',
        ];
    }
}
