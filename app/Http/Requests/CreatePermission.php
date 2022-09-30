<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasPermissionRules;

class CreatePermission extends ApiFormRequest
{
    use HasPermissionRules;
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['name'][] = 'unique:permissions';
        
        return $this->rules;
    }
}
