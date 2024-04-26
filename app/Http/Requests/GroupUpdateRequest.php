<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->can('group.edit')) {
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
                'integer',
                'exists:users,id',
            ],
            'group_name' => [
                'required',
            ],
            'members' => [
                'required',
                'min:2',
                'array',
            ],
            'members.*' => [
                'integer',
                'exists:users,id',
            ],
            'group_icon' => [
                'sometimes',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5000'
            ],
        ];
    }
}
