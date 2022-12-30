<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $courseId)
    {
        return Media::where("course_id", $courseId)->get();
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
            "courseId" => "required"
        ]);
        $fileName = explode(".", $request->file('file')->getClientOriginalName())[0];
        //$extension = $request->file('file')->getClientOriginalExtension();

        $filePath = $request->file('file')->store("public");

        $media = Media::create(["course_id" => $request->courseId, 'name' => $fileName, "type" => $request->type, "url" => $filePath]);
        return response()->json(["File uploaded successfuly"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Media::destroy($id);
        return response()->json(["message" => "media deleted"], 200);
    }
}
