<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/'
            ],
            'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'avatar.image' => 'Avatar must be an image',
            'avatar.mimes' => 'Avatar must be a file of type: jpeg, png, jpg, gif, svg',
            'avatar.max' => 'Avatar must be less than 10MB',
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
