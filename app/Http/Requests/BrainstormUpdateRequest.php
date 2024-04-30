<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrainstormUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->can('brain-storm.edit')) {
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
            'user_id' => ['required', 'exists:users,id'],
            'color_id' => ['required', 'exists:colors,id'],
            'series_id' => ['required', 'exists:series,id'],
            'book_id' => ['required', 'exists:books,id'],
            'brainstorm_name' => ['required', 'string', 'max:100'],
            'transcript' => ['required', 'string', 'max:200'],
            'audio_file' => ['mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav', 'max:5000']
        ];
    }
}
