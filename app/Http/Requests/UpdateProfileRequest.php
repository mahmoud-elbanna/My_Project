<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ✅ أي يوزر Authenticated مسموح له يعدل بياناته
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[\pL\s\-.]+$/u', // ✅ Letters + spaces + dash + dot
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user()->id), 
                // ✅ Unique باستثناء الإيميل الحالي
            ],
            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', // ✅ 2MB Max
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Your name is required.',
            'name.min' => 'Your name must be at least 2 characters.',
            'name.max' => 'Your name may not be greater than 255 characters.',
            'name.regex' => 'The name may contain only letters, spaces, dashes, and dots.',

            'email.required' => 'Your email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Your email may not be greater than 255 characters.',
            'email.unique' => 'This email is already taken.',

            'profile_image.image' => 'The profile image must be a valid image file.',
            'profile_image.mimes' => 'Allowed image formats: jpg, jpeg, png, webp.',
            'profile_image.max' => 'The profile image must not be larger than 2MB.',
        ];
    }
}
