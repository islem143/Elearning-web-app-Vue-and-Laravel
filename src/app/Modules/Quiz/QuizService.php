<?php

namespace App\Modules\Quiz;

use App\Events\MessageSent;
use App\Models\Category;
use App\Models\Course;
use App\Models\Media;
use App\Models\Message;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizService
{

    public function getCourseQuizzes(int $courseId)
    {
        $quizzes = Quiz::where(["course_id" => $courseId])
            ->with(["questions", "questions.choices"])->get();
        return $quizzes;
    }
    public function store($courseId, $data)
    {
        Course::FindOrFail($courseId);


        $quiz = Quiz::create($data);


        return $quiz;
    }
    public function get($quizId)
    {


        $quiz = Quiz::where(["id" => $quizId])
            ->with(["questions", "questions.choices"])
            ->first();

        return $quiz;
    }
    public function getCompleted($quizId)
    {
        $quiz = Auth::user()->quizzes()->where(["quiz_id" => $quizId])->first();
        return $quiz;
    }
    public function saveResult($quizId, $courseId, $data)
    {
        $quiz = Quiz::where(["id" => $quizId])->first();

        Auth::user()->quizzes()->attach($quizId, [
            $data
        ]);

        Auth::user()->courses()->updateExistingPivot($courseId, ["staus" => "completed"]);
        $quiz->save();

        return response()->json(["quiz saved"], 201);
    }
}
