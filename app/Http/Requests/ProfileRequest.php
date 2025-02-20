<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        $userId = Auth::id();

        return [
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($userId)],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
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
            'avatar.mimes' => 'Avatar must be a file of type: :mimes',
            'avatar.max' => 'Avatar must be less than 10MB',
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'username.unique' => 'Username already exists',
            'email.unique' => 'Email already exists',
            'username.max' => 'Username must not be greater than :max characters',
            'email.max' => 'Email must not be greater than :max characters',
            'first_name.max' => 'First name must not be greater than :max characters',
            'last_name.max' => 'Last name must not be greater than :max characters',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
