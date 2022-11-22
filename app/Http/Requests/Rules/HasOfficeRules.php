<?php

namespace App\Http\Requests\Rules;

trait HasOfficeRules
{
    private $rules = [
        'name' => ['required'],
        'short_name' => ['required'],
        'unit' => ['required', 'in:cluster,section,division'],
        'parent_id' => ['nullable', 'exists:offices,id'],
    ];
}