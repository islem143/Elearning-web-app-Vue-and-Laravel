<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {

        return view("auth.register");
    }
    public function store(Request $request)
    {

        $this->validate($request, [
            'email' => "required|email|unique:App\Models\User,email",
            "name" => "required|max:255",
            'password' =>  "required|confirmed"
        ]);

        User::create([
            'email' => $request->email,
            "name" => $request->name,
            "password" => Hash::make($request->password)
        ]);
        auth()->attempt($request->only('email', 'password'));
        return redirect()->route('dashboard.index');
    }
}
