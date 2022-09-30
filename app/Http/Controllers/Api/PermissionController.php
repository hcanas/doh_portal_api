<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePermission;
use App\Http\Requests\UpdatePermission;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Permission::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePermission  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePermission $request)
    {
        return response()->json(Permission::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Permission::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePermission  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePermission $request, $id)
    {
        $permission = Permission::find($id);
        
        $permission->fill($request->validated())
            ->save();
        
        return response()->json($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Permission::find($id)->delete();
        
        return response()->json('', 204);
    }
}
