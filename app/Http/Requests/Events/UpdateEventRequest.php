<?php

namespace App\Http\Requests\Events;

use App\Rules\CanBeAssignedToAnEvent;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'selected_users' => 'teller',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = auth()->user();

        $event = $this->event;

        $extraRules = [];

        if ($event->ticketing) {
            $extraRules = array_merge($extraRules, [
                'ticketing_start_time' => [
                    'nullable',
                    'date',
                    'before:start_time',
                ],
                'ticketing_end_time' => [
                    'nullable',
                    'date',
                    'after:ticketing_start_time',
                ],
                'ticket_price' => [
                    'nullable',
                    'numeric',
                    'min:0.5',
                ],
                'no_of_available_tickets' => [
                    'nullable',
                    'numeric',
                    'gt:0',
                ],
            ]);
        }

        $rules = [
            'name' => ['required', 'max:100'],
            'venue' => ['required', 'max:255'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date', 'after:start_time'],
            // 'expected_attendees' => ['required', 'integer'],
            'greeting_message' => ['required', 'max:100'],
            'goodbye_message' => ['required', 'max:100'],
            'program_lineup' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'selected_users.*' => ['exists:users,id', new CanBeAssignedToAnEvent],
        ];

        if ($user->role == 'admin') {
            $rules = array_merge($rules, [
                'organizer_name' => ['required', 'max:100'],
                'organizer_email' => ['required', 'email', 'max:100'],
                'organizer_phone' => ['required'],
            ]);
        }

        return array_merge($rules, $extraRules);
    }

    public function messages()
    {
        return [
            'program_lineup.max' => 'The :attribute must not be greater than 10MB',
        ];
    }
}
