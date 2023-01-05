<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->authorize("add-quiz", Quiz::class);
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
                "course_id" => $courseId,
                "created_by" => Auth::user()->id
            ]
        );

        return $quiz;
    }

    /**
     * Di201splay the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($courseId, $quizId)
    {   $this->authorize("view", Quiz::class);
        return Quiz::where(["id" => $quizId])->with(["questions", "questions.choices"])->first();
    }

    public function doneQuiz($courseId, $quizId)
    {   
        return Auth::user()->quizzes()->where(["quiz_id" => $quizId])->first();
    }

    public function saveResult(Request $request, $courseId, $quizId)
    {   $this->authorize("saveResult", Quiz::class);
        $this->validate(
            $request,
            [
                "mark" => "required",

                "time" => "required|integer"
            ]
        );
        $quiz = Quiz::where(["id" => $quizId])->first();

        Auth::user()->quizzes()->attach($quizId, [
            "mark" => $request->mark,
            "time" => $request->time
        ]);

        Auth::user()->courses()->updateExistingPivot($courseId, ["staus" => "completed"]);
        $quiz->save();

        return response()->json(["quiz saved"], 201);
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
        $this->authorize("edit-quiz", $quiz);
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
        $this->authorize("delete-quiz", $quiz);
        $quiz->delete();
        return response()->json(["quiz deleted succesfully"]);
    }
}
