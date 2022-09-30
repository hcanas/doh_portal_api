<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Login extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $username = $this->input('username');
        $rules['username'][] = 'exists:users,username';
        $rules['password'][] = function ($attribute, $value, $fail) use ($username) {
            $user = User::where('username', $username)
                ->first();
            
            if(Hash::check($value, $user->password) === false) {
                $fail('Password is incorrect.');
            }
        };
        
        return $rules;
    }
}
