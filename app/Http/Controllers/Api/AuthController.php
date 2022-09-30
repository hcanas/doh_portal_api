<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $permissions = explode(',', $request->input('permissions', ''));
        
        $user = User::query()
            ->with(['credentials' => function ($query) {
                $query->orderByRaw('permission_id ASC, office_id ASC');
            }])
            ->find(Auth::id())
            ->toArray();
    
        $credentials = $user['credentials'];
        unset($user['credentials']);
    
        foreach ($credentials AS $key => $credential) {
            $divider_index = strpos($credential['permission']['name'], ':');
            $permission_group = substr($credential['permission']['name'], 0, $divider_index);
            
            if (count($permissions) > 0 AND !in_array($permission_group, $permissions)) {
                continue;
            }
            
            $temp_key = $credential['permission']['id'];
            $user['permissions'][$temp_key] = $user['permissions'][$temp_key] ?? $credential['permission'];
            $user['permissions'][$temp_key]['offices'][] = $credential['office'];
        }
        
        $user['permissions'] = array_values($user['permissions'] ?? []);
        
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
