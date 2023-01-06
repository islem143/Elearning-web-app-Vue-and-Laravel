<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole(["student", "teacher"])) {
            return User::role(["student", "teacher"])->where('id', "!=", Auth::user()->id)->with('profile')->select(["id", "name"])->get();
        } else {
            return User::with("profile");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->save();

        return User::where('id', Auth::user()->id)->with('profile')->first();
    }
    public function image(Request $request)
    {
        $path =  now()->timestamp . $request->file("image")->getClientOriginalName();
        $request->file('image')->storeAs("public/images", $path);

        $profile = Profile::where("user_id", Auth::user()->id)->first();

        if ($profile->img_url != "profile1.jpeg") {
            Storage::delete("public/" . $profile->img_url);
        }
        $profile->img_url = $path;

        $profile->save();
        return User::where('id', Auth::user()->id)->with('profile')->first();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
