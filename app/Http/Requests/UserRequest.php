<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            // Rules for creating a user
            return [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&#]/'
                ],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
                'role_id' => ['required', 'exists:roles,id'],
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Rules for updating a user
            return [
                'username' => ['sometimes', 'string', 'max:255'],
                'email' => ['sometimes', 'string', 'email', 'max:100'],
                'first_name' => ['sometimes', 'string', 'max:255'],
                'last_name' => ['sometimes', 'string', 'max:255'],
                'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
                'role_id' => ['sometimes', 'exists:roles,id'],
            ];
        }

        return [];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username is required',
            'username.unique' => 'Username already exists',
            'username.string' => 'Username must be a string',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character',
            'first_name.required' => 'First name is required',
            'first_name.string' => 'First name must be a string',
            'last_name.required' => 'Last name is required',
            'role_id.required' => 'Role is required',
            'role_id.exists' => 'Selected role does not exist',
            'avatar.image' => 'Avatar must be an image',
            'avatar.mimes' => 'Avatar must be a file of type: jpeg, png, jpg, gif, svg',
            'avatar.max' => 'Avatar must be less than 10MB',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
