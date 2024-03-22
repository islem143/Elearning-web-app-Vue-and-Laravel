<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Modules\Quiz\QuizService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $quizService;
    public function __construct(QuizService $quizService)
    {

        $this->quizService = $quizService;
    }
    public function index($courseId)
    {
        try {
            $quizzes = $this->quizService->getCourseQuizzes($courseId);
            return $quizzes;
        } catch (Exception $e) {

            return response()->json(["message" => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $courseId)
    {
        try {
            $this->authorize("add-quiz", Quiz::class);
            $this->validate(
                $request,
                [
                    "title" => "required",
                    // "description" => "required",
                    "duration" => "required|integer"
                ]
            );

            $data = [
                "title" => $request->title,
                "duration" => $request->duration,
                "description" => $request->description,
                "course_id" => $courseId,
                "created_by" => Auth::user()->id
            ];
            $quiz = $this->quizService->store($courseId, $data);

            return $quiz;
        } catch (Exception $e) {

            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * Di201splay the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($courseId, $quizId)
    {
        try {
            $this->authorize("view", Quiz::class);
            $quiz = $this->quizService->get($quizId);
            return $quiz;
        } catch (Exception $e) {

            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function doneQuiz($courseId, $quizId)
    {
        try {
            $this->authorize("view", Quiz::class);
            $quiz = $this->quizService->getCompleted($quizId);
            return $quiz;
        } catch (Exception $e) {

            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function saveResult(Request $request, $courseId, $quizId)
    {
        try {
            $this->authorize("saveResult", Quiz::class);
            $this->validate(
                $request,
                [
                    "mark" => "required",

                    "time" => "required|integer"
                ]
            );
            $data = [
                "mark" => $request->mark,
                "time" => $request->time
            ];
            $this->quizService->saveResult($quizId, $courseId, $data);


            return response()->json(["quiz saved"], 201);
        } catch (Exception $e) {
dd($e);
            return response()->json(["message" => $e->getMessage()], 500);
        }
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
