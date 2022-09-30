<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasAnnouncementRules;

class CreateAnnouncement extends ApiFormRequest
{
    use HasAnnouncementRules;
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }
}
