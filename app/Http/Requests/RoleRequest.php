<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
     * @return array'unique:roles'
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'name' => ['required', 'string', 'max:255', 'unique:roles'],
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($this->role)],
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
            'name.max' => 'Name must not exceed :max characters',
            'name.unique' => 'Name already exists',
        ];
    }
}
