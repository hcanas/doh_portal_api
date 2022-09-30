<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasUserRules;

class CreateUser extends ApiFormRequest
{
    use HasUserRules;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['name'][] = 'unique:users';
        $this->rules['username'][] = 'unique:users';
        
        return $this->rules;
    }
}
