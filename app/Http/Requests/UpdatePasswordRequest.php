<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // أي يوزر Authenticated يقدر يغير الباسورد
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Please enter your current password.',
            'password.required' => 'Please enter a new password.',
            'password.min' => 'The new password must be at least 8 characters.',
            'password.confirmed' => 'The new password confirmation does not match.',
        ];
    }
}
