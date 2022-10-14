<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutApiController extends Controller
{
    public function store(Request $request){
        
        auth()->user()->tokens()->delete();

         return['message'=>"Loged Out"];


         
    }
}
