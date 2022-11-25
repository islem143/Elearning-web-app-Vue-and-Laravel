<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($questionId)
    {
        return Choice::where(["question_id" => $questionId])->get();
    }
    public function attach(Request $request, $questionId, $choiceId)
    {
        $user = Auth::user();
        $user->choices()->attach($choiceId, [
            "question_id" => $questionId,
        ]);
        return response()->json("yes");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOne(Request $request, $questionId)
    {
        Question::FindOrFail($questionId);
        $this->validate(
            $request,
            [
                "text" => "required",
                "isCorrect" => "required|boolean",

            ]
        );
        $choice = Choice::create(
            [
                "text" => $request->text,
                "is_correct" => $request->isCorrect,
                "question_id" => $questionId,

            ]
        );
        return $choice;
    }
    public function store(Request $request, $questionId)
    {

        Question::FindOrFail($questionId);
        $this->validate(
            $request,
            [
                "choices.*.text" => "required",
                "choices.*.is_correct" => "required|boolean",

            ]
        );
        foreach ($request->get("choices") as $choice) {

            Choice::create(
                [
                    "text" => $choice["text"],
                    "is_correct" => $choice["is_correct"],
                    "question_id" => $questionId,

                ]
            );
        }


        return response()->json(["choices created"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($choiceId)
    {
        $choice = Choice::FindOrFail($choiceId);
        return $choice;
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

        $this->validate(
            $request,
            [
                "choices.*.text" => "required",
                "choices.*.is_correct" => "required|boolean",

            ]
        );
        dd($request->get("choices"));
        foreach ($request->get("choices") as $choice) {
            $choiceM = Choice::findOrFail($choice["id"]);
            $choiceM->text = $choice["text"];
            $choiceM->is_correct = $choice["is_correct"];
            $choiceM->save();
        }



        // $choice = Choice::findOrFail($choiceId);
        // $choice->update($request->all());
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
        $choice = Choice::findOrFail($choiceId);
        $choice->delete();
        return response()->json(["choice deleted succesfully"]);
    }
}
