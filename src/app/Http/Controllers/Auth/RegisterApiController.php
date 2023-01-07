<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterApiController extends Controller
{
    public function store(Request $request)
    {

        $this->validate($request, [
            'email' => "required|email|unique:App\Models\User,email",
            "name" => "required|max:255",
            'password' =>  "required|confirmed"
        ]);
        $user = User::create([
            'email' => $request->email,
            "name" => $request->name,
            "password" => Hash::make($request->password),



        ]);
        $user->assignRole("student");
        $user->profile()->create(["img_url" => "profile1.jpeg"]);
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }
}
