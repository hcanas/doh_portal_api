<?php

namespace App\Http\Requests;

use App\Models\Office;

class UpdateUserPermission extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'offices' => [function ($attribute, $value, $fail) {
               if (is_array($value) === false) {
                   $fail('Invalid input.');
               }
               
               $office_ctr = Office::query()
                   ->whereIn('id', $value)
                   ->count('id');
               
               if ($office_ctr !== count($value)) {
                   $fail('Unknown offices.');
               }
            }],
        ];
    }
}
