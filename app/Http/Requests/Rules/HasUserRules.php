<?php

namespace App\Http\Requests\Rules;

trait HasUserRules
{
    private $rules = [
        'avatar' => ['nullable', 'file', 'image'],
        'biometrics_id' => ['nullable', 'numeric'],
        'code' => ['nullable'],
        'name' => ['required'],
        'nickname' => ['nullable'],
        'address' => ['nullable'],
        'contact_number' => ['nullable'],
        'email' => ['nullable'],
        'position' => ['nullable'],
        'birthdate' => ['nullable', 'date'],
        'sex' => ['nullable', 'in:Male,Female'],
        'blood_type' => ['nullable'],
        'gsis_number' => ['nullable'],
        'pagibig_number' => ['nullable'],
        'philhealth_number' => ['nullable'],
        'tin_number' => ['nullable'],
        'emergency_contact_name' => ['nullable'],
        'emergency_contact_number' => ['nullable'],
        'contract_from' => ['nullable'],
        'contract_to' => ['nullable'],
        'username' => ['nullable'],
        'password' => ['nullable', 'min:8'],
    ];
}