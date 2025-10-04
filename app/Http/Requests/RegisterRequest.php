<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;




class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'min:2', 'max:255',
                'regex:/^[\pL\s\-.]+$/u',
            ],
            'email' => [
                'required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email',
            ],
            'password' => [
                'required', 'confirmed',
                Password::min(12)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
            ],
            'phone' => [
                'required', 'string', 'max:20', 'unique:users,phone',
                'regex:/^[0-9+\-\s]+$/', // يسمح بأرقام + مسافات + - +
            ],
            'gender' => [
                'required', 'in:male,female,other',
            ],
            'date_of_birth' => [
                'required', 'date', 'before:today',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'The name may contain letters, spaces, dashes, and dots only.',
            'phone.regex' => 'The phone number format is invalid.',
            'phone.unique' => 'This phone number is already taken.',
            'gender.in' => 'Gender must be male, female, or other.',
            'date_of_birth.before' => 'The date of birth must be a valid date before today.',
        ];
    }

    public function attributes(): array
    {
        return [
            'password' => 'password',
            'password_confirmation' => 'password confirmation',
            'phone' => 'phone number',
            'gender' => 'gender',
            'date_of_birth' => 'date of birth',
        ];
    }
}
