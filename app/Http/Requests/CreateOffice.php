<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasOfficeRules;

class CreateOffice extends ApiFormRequest
{
    use HasOfficeRules;
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['name'][] = 'unique:offices';
        $this->rules['short_name'][] = 'unique:offices';
        
        return $this->rules;
    }
}
