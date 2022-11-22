<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class VerifiedEmployeeController extends Controller
{
    public function __invoke($code)
    {
        $employee = User::query()
            ->where('code', Crypt::decryptString($code))
            ->where(function ($query) {
                $query->where(function ($query) {
                        $query->whereNotNull('contract_from')
                            ->where('contract_from', '<=', date('Y-m-d', strtotime('now')));
                    })
                    ->where(function ($query) {
                        $query->whereNull('contract_to')
                            ->orWhere('contract_to', '>=', date('Y-m-d', strtotime('now')));
                    });
            })
            ->first();

        return response()->json($employee);
    }
}
