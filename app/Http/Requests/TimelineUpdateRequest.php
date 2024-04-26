<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimelineUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->can('timeline.edit')) {
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
                'integer',
                'exists:users,id',
            ],
            'series_id' => [
                'required',
                'integer',
                'exists:series,id',
            ],
            'book_id' => [
                'required',
                'integer',
                'exists:books,id'
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'description' => [
                'string',
                'max:200',
                'nullable',
            ],
            'color_id' => [
                'required',
                'integer',
                'exists:colors,id'
            ],
            'status' => [
                'required',
                'boolean',
            ],
        ];
    }
}
