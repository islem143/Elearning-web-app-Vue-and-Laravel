<?php

namespace App\Http\Controllers;

use App\Models\CourseUser;
use App\Models\Module;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        $this->authorize("view", Module::class);
        if (Auth::user()->hasRole(["student", "super-admin"])) {


            if ($request->query("title")) {

                return Module::with("courses")->where("title", 'like', "%" . $request->query("title") . "%")->get();
            }


            return Module::with("courses")->get();
        } else {
            if ($request->query("title")) {

                return Module::with("courses")->where("title", 'like', "%" . $request->query("title") . "%")->get();
            }


            return Module::with("courses")->where("user_id", Auth::user()->id)->get();
        }
    }
    public function compledtedCourses(Request $request, $id)
    {

        $totalCourses = Module::find($id)->courses->count();
        $compltedCourses = DB::table("courses")->join("course_users", "courses.id", "=", "course_users.course_id")->where(["module_id" => $id, "user_id" => Auth::user()->id, "staus" => "completed"])->count();
        return response()->json(["totalCourse" => $totalCourses, "completedCourses" => $compltedCourses]);
    }
    public function joinModule($id)
    {

        $module = Module::FindOrFail($id);
        $can_join_module = Gate::inspect('joinModule', $module);
        if ($can_join_module->allowed()) {

            Auth::user()->modules()->attach($module->id);
            return response()->json(["message" => "student added to module"], 201);
        }
        return response()->json(["message" => $can_join_module->message()], 403);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize("create", Module::class);
        $this->validate($request, [
            "title" => "required",
            "description" => "required",


        ]);

        $module = Module::create([
            "title" => $request->title,
            "descprtion" => $request->description,
            "user_id" => Auth::user()->id
        ]);
        return $module;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize("view", Module::class);

        return Module::where(["id" => $id])->first();
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
        $module = Module::findOrFail($id);
        $this->authorize("update", $module);
        $module->update($request->all());
        return response()->json(["module updated succesfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $this->authorize("delete", $module);
        $module->delete();
        return response()->json(["module deleted succesfully"]);
    }
}
