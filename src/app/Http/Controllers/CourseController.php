<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Course::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id1)
    {   
        $module=Module::findOrFail($id1);
        
        $this->validate($request, [
            "title" => "required",
            "description" => "required"
        ]);

        $course = Course::create([
            "title" => $request->title,
            "description" => $request->description,
            "module_id"=>$module->id
        ]);
        return $course;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         return Course::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id1,$id2)

    {   Module::findOrFail($id1);
        $course=Course::findOrFail($id2);
        $course->update($request->all());
        return response()->json(["course updated succesfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id1,$id2)
    {
        $course=Course::findOrFail($id2);
        $course->delete();
        return response()->json(["course deleted succesfully"]);
    }
}
