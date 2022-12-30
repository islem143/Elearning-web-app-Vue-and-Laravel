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

        if ($request->query("title")) {

            return Module::with("courses")->where("title", 'like', "%".$request->query("title")."%")->get();
        }

      
        return Module::with("courses")->get();
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
        $response = Gate::inspect('joinModule', $module);
        if ($response->allowed()) {

            Auth::user()->modules()->attach($module->id);
            return response()->json(["student added to module"]);
        }
        return $response->message();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required",
            "description" => "required"

        ]);

        $module = Module::create([
            "title" => $request->title,
            "descprtion" => $request->description
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
        //return Module::where(["id" => $id])->with("courses")->first();
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
        $module->delete();
        return response()->json(["module deleted succesfully"]);
    }
}
