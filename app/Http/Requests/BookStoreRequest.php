<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->can('book.add')) {
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
                'exists:users,id'
            ],
            'series_id' => [
                'integer',
                'exists:series,id'
            ],
            'book_name' => [
                'required',
                'string',
                'min:2',
                'max:30',
            ],
            'book_description' => [
                'string',
                'min:2',
                'max:255',
                'nullable',
            ],
            'color_id' => [
                'required',
                'integer',
                'exists:colors,id'
            ],
        ];
    }
}
