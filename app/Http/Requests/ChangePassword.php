<?php

namespace App\Http\Requests;

class ChangePassword extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'current_password' => ['required', 'min:8', 'current_password'],
            'new_password' => ['required', 'min:8'],
            'confirm_password' => ['same:new_password'],
        ];
    }
}
