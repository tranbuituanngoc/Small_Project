<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HotelRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            // Rules for creating a hotel
            return [
                'name' => ['required', 'string', 'max:255', 'unique:hotels'],
                'hotel_code' => ['required', 'string', 'max:255', 'unique:hotels'],
                'email' => ['required', 'string', 'email', 'max:100'],
                'tel' => ['required', 'string', 'size:10', 'regex:/^[0-9]+$/'],
                'fax' => ['required', 'string', 'min:10', 'max: 12', 'regex:/^[0-9]+$/'],
                'company_name' => ['required', 'string', 'max:255'],
                'tax_code' => ['required', 'string', 'min:10', 'max:13', 'regex:/^[0-9]+$/'],
                'address1' => ['required', 'string', 'max:255'],
                'address2' => ['nullable', 'string', 'max:255'],
                'city_id' => ['required', 'exists:cities,id'],
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Rules for updating a hotel
            return [
                'name' => ['sometimes', 'string', 'max:255'],
                'hotel_code' => ['sometimes', 'string', 'max:255'],
                'email' => ['sometimes', 'string', 'email', 'max:100'],
                'tel' => ['sometimes', 'string', 'size:10', 'regex:/^[0-9]+$/'],
                'fax' => ['sometimes', 'string', 'min:10', 'max: 12', 'regex:/^[0-9]+$/'],
                'company_name' => ['sometimes', 'string', 'max:255'],
                'tax_code' => ['sometimes', 'string', 'min:10', 'max:13', 'regex:/^[0-9]+$/'],
                'address1' => ['sometimes', 'string', 'max:255'],
                'address2' => ['nullable', 'string', 'max:255'],
                'city_id' => ['sometimes', 'exists:cities,id'],
            ];
        }

        return [];
    }

    /**
     * Message to be shown when validation fails
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Hotel name is required',
            'name.string' => 'Hotel name must be a string',
            'name.max' => 'Hotel name must not be greater than :max characters',
            'name.unique' => 'Hotel name already exists',
            'hotel_code.required' => 'Hotel code is required',
            'hotel_code.string' => 'Hotel code must be a string',
            'hotel_code.max' => 'Hotel code must not be greater than :max characters',
            'hotel_code.unique' => 'Hotel code already exists',
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'email.email' => 'Email must be a valid email',
            'email.max' => 'Email must not be greater than :max characters',
            'tel.required' => 'Telephone is required',
            'tel.string' => 'Telephone must be a string',
            'tel.size' => 'Telephone must be :size characters',
            'tel.regex' => 'Telephone must be a valid number',
            'fax.required' => 'Fax is required',
            'fax.string' => 'Fax must be a string',
            'fax.min' => 'Fax must be at least :min characters',
            'fax.max' => 'Fax must not be greater than :max characters',
            'fax.regex' => 'Fax must be a valid number',
            'company_name.required' => 'Company name is required',
            'company_name.string' => 'Company name must be a string',
            'company_name.max' => 'Company name must not be greater than :max characters',
            'tax_code.required' => 'Tax code is required',
            'tax_code.string' => 'Tax code must be a string',
            'tax_code.min' => 'Tax code must be at least :min characters',
            'tax_code.max' => 'Tax code must not be greater than :max characters',
            'tax_code.regex' => 'Tax code must be a valid number',
            'address1.required' => 'Address 1 is required',
            'address1.string' => 'Address 1 must be a string',
            'address1.max' => 'Address 1 must not be greater than :max characters',
            'address2.string' => 'Address 2 must be a string',
            'address2.max' => 'Address 2 must not be greater than :max characters',
        ];
    }
}
