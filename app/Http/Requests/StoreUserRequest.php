<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\IsPhoneNumber;
use App\Rules\IsUniquePhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique(User::class)],
            'phone' => [
                'bail',
                'required',
                new IsPhoneNumber,
                new IsUniquePhoneNumber,
            ],
            'role' => ['required', Rule::in(['teller', 'client_admin'])],
            'parent' => 'required',
        ];
    }
}
