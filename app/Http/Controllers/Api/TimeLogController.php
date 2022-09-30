<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TimeLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    public function __invoke(Request $request)
    {
        $response = Http::get('http://192.168.224.64:8000/'.$request->input('id')
            .'/monthly/'.$request->input('month')
            .'/'.$request->input('year'));
    
        return response()->json($response->json());
    }
}
