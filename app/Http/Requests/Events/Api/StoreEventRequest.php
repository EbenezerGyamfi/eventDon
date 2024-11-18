<?php

namespace App\Http\Requests\Events\Api;

use App\Rules\CanBeAssignedToAnEvent;
use App\Rules\IsValidEventEndTime;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
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
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'selected_users' => 'teller',
            'contact_group_id' => 'contact group',
            'questions.*.title' => 'question title',
            'questions.*.question' => 'question',
            'questions.*.order' => 'question order',
            'pre_registration_questions.*.title' => 'question title',
            'pre_registration_questions.*.question' => 'question',
            'pre_registration_questions.*.order' => 'question order',
            'tickets.*.name' => 'ticket name',
            'tickets.*.price' => 'ticket price',
            'tickets.*.no_of_available_tickets' => 'number of available tickets',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /***
         * The network service providers don't handle special characters well in
         * USSD prompts.
         * ( { } [ ] ( ) / \ ' " ` ~ , ; : < > ? | + = * & ^ % $ # @ !) are characters
         * that should be restricted in any field that gets displayed
         * in the USSD prompt
         */

        return [
            'name' => ['required', 'max:50'],
            'venue' => ['required', 'max:255'],
            'start_time' => ['required', 'date'],
            'end_time' => [
                'bail',
                'required',
                'date',
                'after:start_time',
                new IsValidEventEndTime($this->start_time),
            ],
            'pre_registration_start_time' => [
                'nullable',
                'required_if:enable_pre_registration,true',
                'date',
                'before:start_time',
            ],
            'pre_registration_end_time' => [
                'nullable',
                'required_if:enable_pre_registration,true',
                'date',
                'before_or_equal:start_time',
                'after:pre_registration_start_time',
            ],
            'ticketing' => ['required', 'boolean'],
            'ticketing_start_time' => [
                'required_if:ticketing,true',
                'date',
                'before:start_time',
            ],
            'ticketing_end_time' => [
                'required_if:ticketing,true',
                'date',
                'after:ticketing_start_time',
            ],
            'tickets' => [
                'required_if:ticketing,true',
            ],
            'tickets.*.name' => [
                'required',
                'string',
                'max:50',
                "regex:/^[^*|\":<>[\]{}`\\()';@&$]+$/",
            ],
            'tickets.*.price' => [
                'required',
                'numeric',
                'min:0.5',
            ],
            'tickets.*.no_of_available_tickets' => [
                'required',
                'numeric',
                'gt:0',
            ],
            'type' => ['required', Rule::in(['funeral', 'other'])],
            'expected_attendees' => ['required', 'integer'],
            'greeting_message' => ['required', 'max:100', "regex:/^[^*|\":<>[\]{}`\\()';@&$]+$/"],
            'goodbye_message' => ['required', 'max:100', "regex:/^[^*|\":<>[\]{}`\\()';@&$]+$/"],
            'program_lineup' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'questions' => ['nullable'],
            'questions.*.title' => ['required', 'max:50', "regex:/^[^*|\":<>[\]{}`\\()';@&$]+$/"],
            'questions.*.question' => ['required', 'max:100', "regex:/^[^*|\":<>[\]{}`\\()';@&$]+$/"],
            'questions.*.order' => ['required', 'numeric', 'min:1'],
            'enable_pre_registration' => ['required', 'boolean'],
            'enable_pre_registration_questions' => ['required', 'boolean'],
            'pre_registration_questions' => ['required_if:enable_pre_registration_questions,true'],
            'pre_registration_questions.*.title' => [
                'required',
                'max:50',
                "regex:/^[^*|\":<>[\]{}`\\()';@&$]+$/",
            ],
            'pre_registration_questions.*.question' => [
                'required',
                'max:100',
                "regex:/^[^*|\":<>[\]{}`\\()';@&$]+$/",
            ],
            'pre_registration_questions.*.order' => ['required', 'numeric', 'min:1'],
            'contact_group_id' => ['nullable', 'exists:contact_groups,id'],
            'selected_users' => ['nullable'],
            'selected_users.*' => ['exists:users,id', new CanBeAssignedToAnEvent],
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'enable_pre_registration' => $this->boolean('enable_pre_registration'),
            'enable_pre_registration_questions' => $this->boolean('enable_pre_registration_questions'),
            'ticketing' => $this->boolean('ticketing'),
        ]);
    }

    public function messages()
    {
        return [
            'program_lineup.max' => 'The :attribute must not be greater than 10MB',
            'pre_registration_questions.required_if' => 'You must add at least one pre registration question',
            'pre_registration_start_time.required_if' => 'Please specify when the pre-registration period will begin',
            'pre_registration_end_time.required_if' => 'Please specify when the pre-registration period will end',
            'ticketing_start_time.required_if' => 'The :attribute is required',
            'ticketing_end_time.required_if' => 'The :attribute is required',
            'tickets.required_if' => 'The :attribute is required',
        ];
    }
}
