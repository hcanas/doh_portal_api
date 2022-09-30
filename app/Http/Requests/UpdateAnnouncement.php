<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasAnnouncementRules;

class UpdateAnnouncement extends ApiFormRequest
{
    use HasAnnouncementRules;
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['id'] = ['required', 'exists:announcements'];
        
        return $this->rules;
    }
}
