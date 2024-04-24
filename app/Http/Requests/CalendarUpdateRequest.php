<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->can('calendar.edit')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'integer'
            ],
            'title' => [
                'required',
                'string',
                'min:2',
                'max:30',
            ],
            'description' => [
                'string',
                'max:1024',
                'nullable',
            ],
            'event_date' => [
                'required',
            ],
            'start_time' => [
                'required',
            ],
            'end_time' => [
                'required',
                'date_format:' . 'H:i:s',
            ],
            'color_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
