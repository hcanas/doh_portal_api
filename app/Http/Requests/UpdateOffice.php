<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasOfficeRules;

class UpdateOffice extends ApiFormRequest
{
    use HasOfficeRules;
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['id'] = ['required', 'exists:offices'];
        $this->rules['name'][] = 'unique:offices,name,'.$this->route('office');
        $this->rules['short_name'][] = 'unique:offices,short_name,'.$this->route('office');
        
        return $this->rules;
    }
}
