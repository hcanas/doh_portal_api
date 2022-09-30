<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAnnouncement;
use App\Http\Requests\UpdateAnnouncement;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
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
        return response()->json(Announcement::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAnnouncement $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAnnouncement $request)
    {
        return response()->json(Announcement::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Announcement::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAnnouncement $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAnnouncement $request, $id)
    {
        $announcement = Announcement::find($id);
        
        $announcement->fill($request->validated())
            ->save();
        
        return response()->json($announcement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Announcement::find($id)->delete();
        
        return response()->json('', 204);
    }
}
