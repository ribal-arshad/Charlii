<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserAccountUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (Auth::user()->getRoleNames()[0] !== User::ADMIN){
            return [
                'name' => 'required|alpha|max:255',
                'email' => 'required|unique:users,email,'.Auth::id().'|max:255',
                'password' => 'sometimes|nullable|min:8|max:255|confirmed',
            ];
        }else{
            return [
                'name' => 'required|alpha|max:255',
                'email' => 'required|unique:users,email,'.Auth::id().'|max:255',
                'password' => 'sometimes|nullable|min:8|max:255|confirmed',
            ];
        }

    }

    public function messages()
    {
        return [
            'password.min' => 'The new password must be at least 8 characters.',
            'password.max' => 'The new password must not be greater than 255 characters.',
            'password.confirmed' => 'The new password confirmation does not match.'
        ];
    }
}
