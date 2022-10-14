<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {echo asset('storage/file.txt');

        return view('auth.login');
    }

    public function store(Request $request)
    {
       
        $cred=$this->validate($request,[
            "email"
            => 'required|email',
            "password" => 'required'
        ]);
        
        if(!auth()->attempt($cred)){
           
            return back()->with('status','Invalid login credentials');
        }
        
        
        $request->session()->regenerate();
        return redirect()->route('dashboard.index');

    }
}
