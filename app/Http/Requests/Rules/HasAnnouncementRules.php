<?php

namespace App\Http\Requests\Rules;

trait HasAnnouncementRules
{
    private $rules = [
        'title' => ['required'],
        'description' => ['required'],
    ];
}