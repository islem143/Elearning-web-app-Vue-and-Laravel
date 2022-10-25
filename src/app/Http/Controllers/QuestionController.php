<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($quizId)
    {
        return Question::where(["quiz_id"=>$quizId])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$quizId)
    {
        Quiz::FindOrFail($quizId);
        $this->validate($request,
        [
            "text"=>"required",
        ]);
        $question=Question::create(
        [
        "text"=>$request->text,
        "quiz_id"=>$quizId]);

        return $question;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($quizId,$questionId)
    {
        $question=Question::FindOrFail($questionId);
        return $question;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $questionId)
    {
        $question=Question::findOrFail($questionId);
        $question->update($request->all());
        return response()->json(["question updated succesfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($quizId,$questionId)
    {
        $question=Question::findOrFail($questionId);
        $question->delete();
        return response()->json(["question deleted succesfully"]);
    }
}
