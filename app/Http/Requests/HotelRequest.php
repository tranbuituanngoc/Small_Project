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
                'email' => ['required', 'string', 'email:rfc,dns', 'max:100'],
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
                'name' => ['required', 'string', 'max:255'],
                'hotel_code' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email:rfc,dns', 'max:100'],
                'tel' => ['required', 'string', 'size:10', 'regex:/^[0-9]+$/'],
                'fax' => ['required', 'string', 'min:10', 'max: 12', 'regex:/^[0-9]+$/'],
                'company_name' => ['required', 'string', 'max:255'],
                'tax_code' => ['required', 'string', 'min:10', 'max:13', 'regex:/^[0-9]+$/'],
                'address1' => ['required', 'string', 'max:255'],
                'address2' => ['nullable', 'string', 'max:255'],
                'city_id' => ['required', 'exists:cities,id'],
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
            'name.max' => 'Hotel name must not be greater than :max characters',
            'name.unique' => 'Hotel name already exists',
            'hotel_code.required' => 'Hotel code is required',
            'hotel_code.max' => 'Hotel code must not be greater than :max characters',
            'hotel_code.unique' => 'Hotel code already exists',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email',
            'email.max' => 'Email must not be greater than :max characters',
            'tel.required' => 'Telephone is required',
            'tel.size' => 'Telephone must be :size characters',
            'tel.regex' => 'Telephone must be a valid number',
            'fax.required' => 'Fax is required',
            'fax.min' => 'Fax must be at least :min characters',
            'fax.max' => 'Fax must not be greater than :max characters',
            'fax.regex' => 'Fax must be a valid number',
            'company_name.required' => 'Company name is required',
            'company_name.max' => 'Company name must not be greater than :max characters',
            'tax_code.required' => 'Tax code is required',
            'tax_code.min' => 'Tax code must be at least :min characters',
            'tax_code.max' => 'Tax code must not be greater than :max characters',
            'tax_code.regex' => 'Tax code must be a valid number',
            'address1.required' => 'Address 1 is required',
            'address1.max' => 'Address 1 must not be greater than :max characters',
            'address2.max' => 'Address 2 must not be greater than :max characters',
            'city_id.required' => 'City is required',
        ];
    }
}
