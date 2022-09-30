<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasPermissionRules;

class UpdatePermission extends ApiFormRequest
{
    use HasPermissionRules;
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['id'] = ['required', 'exists:permissions'];
        $this->rules['name'][] = 'unique:permissions,name,'.$this->route('permission');
        
        return $this->rules;
    }
}
