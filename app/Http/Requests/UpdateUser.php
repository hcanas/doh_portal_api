<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasUserRules;

class UpdateUser extends ApiFormRequest
{
    use HasUserRules;
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['id'] = ['required', 'exists:users'];
        $this->rules['name'][] = 'unique:users,name,'.$this->route('user');
        $this->rules['username'][] = 'unique:users,username,'.$this->route('user');
        
        return $this->rules;
    }
}
