<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPermission;
use App\Models\Credential;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $permissions = Permission::with(['offices' => function ($query) use ($id) {
                $query->whereRaw('credentials.user_id = '.$id)
                    ->orderByRaw('credentials.permission_id ASC, offices.short_name ASC');
            }])
            ->get();
    
        return response()->json($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $user_id
     * @param  int  $permission_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user_id, $permission_id)
    {
        $permission = Permission::with(['offices' => function ($query) use ($user_id) {
                $query->whereRaw('credentials.user_id = '.$user_id);
            }])
            ->find($permission_id);
        
        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserPermission $request
     * @param int $user_id
     * @param int $permission_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserPermission $request, $user_id, $permission_id)
    {
        try {
            DB::beginTransaction();
    
            Credential::query()
                ->where('user_id', $user_id)
                ->where('permission_id', $permission_id)
                ->delete();
            
            Credential::query()
                ->insert(array_map(function ($x) use ($user_id, $permission_id) {
                    return [
                        'user_id' => $user_id,
                        'permission_id' => $permission_id,
                        'office_id' => $x,
                    ];
                }, $request->validated()['offices']));
            
            DB::commit();
            
            return $this->show($user_id, $permission_id);
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            return response()->json('Unable to update permission. Please try again later.', 500);
        }
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
