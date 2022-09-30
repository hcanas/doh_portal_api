<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
        return response()->json(User::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUser  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUser $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            }

            $user = User::create($data);

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $user->id.'_'.bin2hex(random_bytes(8)).'.'.$file->getClientOriginalExtension();
                Storage::put('public/photos/'.$filename, $file->getContent());

                $user->fill(['avatar' => $filename])
                    ->save();
            }

            DB::commit();

            return $this->show($user->id);
        } catch (\Exception $e) {
            logger($e);
            return response()->json('Unable to create user. Please try again later.', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUser  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUser $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $user = User::find($id);
        
            $data = $request->validated();
        
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $data['avatar'] = $user->id.'_'.bin2hex(random_bytes(8)).'.'.$file->getClientOriginalExtension();
            
                if ($user->avatar) {
                    Storage::delete('public/photos/'.$user->avatar);
                }
            
                Storage::put('public/photos/'.$data['avatar'], $file->getContent());
            } elseif ($request->input('remove_avatar')) {
                $data['avatar'] = null;
                Storage::delete('public/photos/'.$user->avatar);
            }
        
            $data['password'] = $data['password'] ? Hash::make($data['password']) : $user->password;
        
            $user->fill($data);
            $user->save();
        
            DB::commit();
        
            return $this->show($user->id);
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            return response()->json('Unable to update user. Please try again later.', 500);
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
    
    }
}
