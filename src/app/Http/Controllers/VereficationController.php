<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Spatie\UrlSigner\Laravel\UrlSignerFacade;

class VereficationController extends Controller
{



    public function verify(Request $request)

    {
        // if (!UrlSignerFacade::validate($request->url)) {
        //     return response()->json(["message" => "invalid url"], 403);
        // }

        $user = User::findOrFail($request->id);
        if (!hash_equals(
            sha1($user->getEmailForVerification()),
            (string) $request->hash
        )) {
            return response()->json(["message" => "email verification failed"], 403);
        }
        if ($user->hasVerifiedEmail()) {
            return response()->json(["message" => "email already verified", "success" => false], 403);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));
        return response()->json(["message" => "email  verified successfully", "success" => true], 200);
    }

    public function resendVerificationEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(["message" => "email not found"], 404);
        }
        $user->sendEmailVerificationNotification();
        return response()->json(["message" => "check your email"], 201);
    }
}
