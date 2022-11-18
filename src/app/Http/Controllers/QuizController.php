<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($courseId)
    {
        return Quiz::where(["course_id" => $courseId])->with(["questions", "questions.choices"])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $courseId)
    {
        Course::FindOrFail($courseId);
        $this->validate(
            $request,
            [
                "title" => "required",
                // "description" => "required",
                "duration" => "required|integer"
            ]
        );
        $quiz = Quiz::create(
            [
                "title" => $request->title,
                "duration" => $request->duration,
                "description" => $request->description,
                "course_id" => $courseId
            ]
        );

        return $quiz;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($courseId,$quizId)
    {
        return Quiz::where(["id"=>$quizId])->with(["questions", "questions.choices"])->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $courseId, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->update($request->all());
        return response()->json(["quiz updated succesfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($courseId, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->delete();
        return response()->json(["quiz deleted succesfully"]);
    }
}
