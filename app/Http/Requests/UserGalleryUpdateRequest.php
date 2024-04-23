<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGalleryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->can('user.gallery.edit')) {
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
            'image' => ['sometimes', 'image', 'mimes:png,jpg,jpeg', 'max:5000'],
            'user_id' => ['required'],
            'status' => ['required', 'boolean'],
        ];
    }
}
