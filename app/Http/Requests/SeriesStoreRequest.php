<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->can('series.add')) {
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
            'series_name' => [
                'string',
                'min:2',
                'max:30',
                'required',
            ],
            'series_description' => [
                'string',
                'min:2',
                'max:255',
                'nullable',
            ],
            'books' => [
                'array',
            ],
            'books.*' => [
                'integer',
            ],
            'color_id' => [
                'required',
                'integer',
                'exists:colors,id'
            ],
            'is_finished' => [
                'required',
                'boolean',
            ],
            'status' => [
                'required',
                'boolean',
            ],
        ];
    }
}
