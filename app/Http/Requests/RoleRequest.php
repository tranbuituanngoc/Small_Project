<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            // Rules for creating a hotel
            return [
                'name' => ['required', 'string', 'max:255', 'unique:roles'],
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Rules for updating a hotel
            return [
                'name' => ['sometimes', 'string', 'max:255', 'unique:roles'],
            ];
        }
    }

    /**
     * Message to be shown when validation fails
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not exceed 255 characters',
            'name.unique' => 'Name already exists',
        ];
    }
}
