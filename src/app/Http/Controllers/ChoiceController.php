<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($questionId)
    {
        return Choice::where(["question_id"=>$questionId])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$questionId)
    {
        Question::FindOrFail($questionId);
        $this->validate($request,
        [
            "text"=>"required",
            "is_correct"=>"required|boolean",

        ]);
        $choice=Choice::create(
        [
        "text"=>$request->text,
        "is_correct"=>$request->is_correct,
        "question_id"=>$questionId,
                  
    ]);

        return $choice;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($choiceId)
    {
        $choice=Choice::FindOrFail($choiceId);
        return $choice;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $choiceId)
    {
        $choice=Choice::findOrFail($choiceId);
        $choice->update($request->all());
        return response()->json(["choice updated succesfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($choiceId)
    {
        $choice=Choice::findOrFail($choiceId);
        $choice->delete();
        return response()->json(["choice deleted succesfully"]);
    }
}
