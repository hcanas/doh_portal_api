<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOffice;
use App\Http\Requests\UpdateOffice;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
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
        return response()->json(Office::with('parent')
            ->orderBy('name')
            ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOffice $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOffice $request)
    {
        return response()->json(Office::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Office::with('parent')
            ->find($id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOffice $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOffice $request, $id)
    {
        $office = Office::find($id);
        
        $office->fill($request->validated())
            ->save();
        
        return response()->json($office);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Office::find($id)->delete();
        
        return response()->json('', 204);
    }
}
