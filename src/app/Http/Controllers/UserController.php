<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            $users = User::with(["profile", "roles"])->where("id", "!=", Auth::user()->id)->get();

            foreach ($users as $user) {

                $user->role = $user->roles[0]->name;
            }
            return $users;
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
        $this->authorize("update", User::class);
        $this->validate($request, [
            'email' => "required|email|unique:App\Models\User,email",
            "name" => "required|max:255",
            'password' =>  "required|confirmed",
            'role' =>  "required|string"
        ]);
        $user = User::create([
            'email' => $request->email,
            "name" => $request->name,
            "password" => Hash::make($request->password),



        ]);
        $user->assignRole($request->role);
        $user->profile()->create(["img_url" => "profile1.jpeg"]);



        $user = User::where('id', $user->id)->with(['roles', 'profile'])->first();
        $user->role = $user->roles[0]->name;
        return $user;;
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [

            "name" => "required|max:255",


        ]);
        $arr = [];
        $arr["name"] = $request->name;
        if ($request->password) {
            $this->validate($request, [
                'password' =>  "confirmed",
            ]);
            $arr["password"] = Hash::make($request->password);
        }
        $this->authorize("update", $id);
        if (Auth::user()->hasRole(["super-admin"])) {
            $user = User::find($id);
            $user->update($arr);

            $user = User::where('id', $id)->with(['roles', 'profile'])->first();
            $user->role = $user->roles[0]->name;
            return $user;
        } else {

            $user = User::find($id);
            $user->name = $request->name;
            $user->save();
            $user = User::where('id', $id)->with(['roles', 'profile'])->first();
            $user->role = $user->roles[0]->name;
            return $user;
        }
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
    public function destroy(Request $request, $id)
    {
        $this->authorize("delete", User::class);
        return User::destroy($id);
    }
}
