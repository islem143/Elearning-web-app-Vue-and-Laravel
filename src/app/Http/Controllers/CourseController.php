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
use App\Modules\Course\CourseService;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $courseService;
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index($id1)
    {


        $this->authorize("view", Course::class);
        if (Auth::user()->getRoleNames()[0] == "teacher") {

            return $this->courseService->getTeacherCourses($id1);
        } else {
            return $this->courseService->getStudentCourses($id1);
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

        $this->authorize("create", Course::class);

        return $this->courseService->createCourse($id1, $request->all());
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
        $this->authorize("startCourse", Course::class);
        $s = Auth::user()->courses()->where("id", $id2)->first();
        if ($s && $s->status = "in_progress") {
            return response()->json(["message" => "course in progress"], 403);
        } else if ($s && $s->status = "completed") {
            return response()->json(["message" => "course already completed"], 403);
        } else {
            Auth::user()->courses()->attach($course->id, ["staus" => "in_progress"]);
            return response()->json(["message" => "course started"], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id1, $id2)
    {
        $this->authorize("view", Course::class);
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
        $this->authorize("update", $course);
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
        $this->authorize("delete", $course);
        $course->delete();
        return response()->json(["course deleted succesfully"]);
    }
}
