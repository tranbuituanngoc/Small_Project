<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            // Rules for creating a user
            return [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email:rfc,dns', 'max:100', 'unique:users'],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&#]/',
                    'confirmed'
                ],
                'password_confirmation' => ['required', 'string', 'min:8'],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
                'role_id' => ['required', 'exists:roles,id'],
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Rules for updating a user
            return [
                'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->user)],
                'email' => ['required', 'string', 'email:rfc,dns', 'max:100', Rule::unique('users', 'email')->ignore($this->user)],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
                'role_id' => ['required', 'exists:roles,id'],
            ];
        }

        return [];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username is required',
            'username.unique' => 'Username already exists',
            'username.max' => 'Username must not be greater than :max characters',
            'email.max' => 'Email must not be greater than :max characters',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least :min characters',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character',
            'password.confirmed' => 'Password confirmation does not match',
            'password_confirmation.required' => 'Confirm password is required',
            'password_confirmation.min' => 'Confirm password must be at least :min characters',
            'first_name.required' => 'First name is required',
            'first_name.max' => 'First name must not be greater than :max characters',
            'last_name.required' => 'Last name is required',
            'last_name.max' => 'Last name must not be greater than :max characters',
            'role_id.required' => 'Role is required',
            'role_id.exists' => 'Selected role does not exist',
            'avatar.image' => 'Avatar must be an image',
            'avatar.mimes' => 'Avatar must be a file of type: :mimes',
            'avatar.max' => 'Avatar must be less than 10MB',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
