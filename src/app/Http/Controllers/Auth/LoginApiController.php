<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginApiController extends Controller
{
    public function store(Request $request)
    {

        $this->validate($request, [
            'email' => "required|email",

            'password' =>  "required"
        ]);

        $user = User::where('email', $request->email)->with('profile')->first();
        if (!$user) {
            return Response(["errors" => ["email" => ["User with this email not found"]], "message" => "not found"], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return Response(["errors" => ["password" => ["Invalid Password"]], "message" => "invalid password"], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
  
        $response = [
            'user' => $user,
            'token' => $token,
            "roles"=>$user->getRoleNames()

       
        ];
        return response($response, 201);
    }
}
