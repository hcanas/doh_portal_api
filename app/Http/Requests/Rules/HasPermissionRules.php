<?php

namespace App\Http\Requests\Rules;

trait HasPermissionRules
{
    private $rules = [
        'name' => ['required'],
        'description' => ['required'],
    ];
}