<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Media;
use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id1)
    {
        if (Auth::user()->getRoleNames()[0] == "teacher") {
            $courses = Course::where(["module_id" => $id1])->with(["media", "coursesContent"])->get();
            foreach ($courses as $course) {


                $quizzes = DB::table("quizzes")->leftJoin("quiz_user", "quizzes.id", "=", "quiz_user.quiz_id")->where(["quizzes.course_id" => $course->id])->select("quizzes.*", "quiz_user.*")->first();
                $course->quiz = $quizzes;
            }
            return $courses;
        } else {

            $courses_users = DB::table("course_users")->where("user_id", Auth::user()->id);
            $courses = DB::table("courses")->leftJoinSub($courses_users, "course_users", function ($join) {
                $join->on("courses.id", "course_users.course_id");
            })->where(["module_id" => $id1])->get();



            foreach ($courses as $course) {


                if (!$course->user_id) {
                    $course->is_taken = false;
                } else {
                    $course->is_taken = true;

                    $media = Media::where(["course_id" => $course->id])->get();
                    $content = CourseContent::where(["course_id" => $course->id])->get();
                    $quiz_user = DB::table("quiz_user")->where("user_id", Auth::user()->id);

                    $quiz = DB::table("quizzes")->leftJoinSub($quiz_user, "quiz_user", "quizzes.id", "=", "quiz_user.quiz_id")->where(["quizzes.course_id" => $course->id])->select("quizzes.*", "quiz_user.*")->first();
                    $course->quiz = $quiz;
                    $course->media = $media;
                    $course->contents = $content;
                }
            }

            return $courses;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id1)
    {
        $module = Module::findOrFail($id1);

        $this->validate($request, [
            "title" => "required",
            "description" => "required"
        ]);
        $count = Course::count();
        $course = Course::create([
            "title" => $request->title,
            "description" => $request->description,
            "module_id" => $module->id,
            "order" => $count
        ]);

        return $course;
    }
    public function storeContent(Request $request, $id1, $id2)
    {
        $course = Course::findOrFail($id2);
        $this->validate($request, [
            "content" => "required",

        ]);
        $course->coursesContent()->create([
            "content" =>    json_encode($request->content)
        ]);
        return response()->json("course content created", 201);
    }
    public function startCourse(Request $request, $id1, $id2)
    {
        $module = Module::findOrFail($id1);
        $course = Course::where(["id" => $id2])->first();

        $s = Auth::user()->courses()->where("id", $id2)->first();
        if ($s && $s->status = "in_progress") {
            return response()->json(["message" => "course in progress"], 403);
        } else if ($s && $s->status = "completed") {
            return response()->json(["message" => "course already completed"], 403);
        } else {
            Auth::user()->courses()->attach($course->id, ["staus" => "in_progress"]);
            return response()->json(["message" => "course started"], 201);
        }

        // if ($course->order == 0 or !$s) {
        //     Auth::user()->courses()->attach($course->id, ["staus" => "in_progress"]);
        //     return response()->json(["message" => "course attached"], 201);
        // } else if ($course->order > 1  and (Auth::user()->courses()->where(["module_id" => $id1, "order" => $course->order - 1])->first()) and Auth::user()->courses()->where(["module_id" => $id1, "order" => $course->order - 1])->first()->pivot->staus == "completed" and (!Auth::user()->courses()->where(["module_id" => $id1, "id" => $id2])->first())) {
        //     Auth::user()->courses()->attach($course->id, ["staus" => "in_progress"]);
        //     return response()->json(["message" => "course attached"], 201);
        // }







    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id1, $id2)
    {

        $course = Course::where(["id" => $id2])->with(["media"])->first();
        $quiz = DB::table("quizzes")->leftJoin("quiz_user", "quizzes.id", "=", "quiz_user.quiz_id")->where(["quizzes.course_id" => $course->id])->select("quizzes.*", "quiz_user.*")->first();
        $course->quiz = $quiz;
        $course->is_taken = true;
        return $course;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id1, $id2)

    {
        Module::findOrFail($id1);
        $course = Course::findOrFail($id2);
        $course->update($request->all());
        return response()->json(["course updated succesfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id1, $id2)
    {
        $course = Course::findOrFail($id2);
        $course->delete();
        return response()->json(["course deleted succesfully"]);
    }
}
