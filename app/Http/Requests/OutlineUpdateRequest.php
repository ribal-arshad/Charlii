<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutlineUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->can('outline.edit')) {
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
            'outline_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'outline_title' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'description' => [
                'string',
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
