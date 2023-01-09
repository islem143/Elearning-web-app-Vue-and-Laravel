<?php

namespace App\Modules\Course;

use App\Models\Course;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseService
{
    protected $validator;
    public function __construct(CourseValidator $validator)
    {
        $this->validator = $validator;
    }
    public function getTeacherCourses($moduleId)
    {

        $courses = Course::where(["module_id" => $moduleId])->with(["media", "coursesContent", "quizzes" => function ($query) {
            $query->where("created_by", Auth::user()->id)->first();
        }])->where("user_id", Auth::user()->id)->get();

        return $courses;
    }

    public function getStudentCourses($moduleId)
    {

        $courses_users = DB::table("course_users")->where("user_id", Auth::user()->id);
        $courses = DB::table("courses")->leftJoinSub($courses_users, "course_users", function ($join) {
            $join->on("courses.id", "course_users.course_id");
        })->where(["module_id" => $moduleId])->get();
        // $courses = Course::with(
        //     [
        //         "users" => function ($query) {
        //             $query->where("user_id", Auth::user()->id);
        //         },
        //         "media", "quizzes" => function ($query) {
        //             $query->leftJoin("quiz_user", "quizzes.id", "=", "quiz_user.quiz_id")->first();
        //         }

        //     ]
        // )->get();
        // dd($courses);

        foreach ($courses as $course) {


            if (!$course->user_id) {
                $course->is_taken = false;
            } else {
                $course->is_taken = true;

                $media = Media::where(["course_id" => $course->id])->get();
                //$content = CourseContent::where(["course_id" => $course->id])->get();
                $quiz_user = DB::table("quiz_user")->where("user_id", Auth::user()->id);

                $quiz = DB::table("quizzes")->leftJoinSub($quiz_user, "quiz_user", "quizzes.id", "=", "quiz_user.quiz_id")->where(["quizzes.course_id" => $course->id])->select("quizzes.*", "quiz_user.*")->get();
                $course->quizzes = $quiz;
                $course->media = $media;
                //$course->contents = $content;
            }
        }

        return $courses;
    }

    public function createCourse($moduleId, $data)
    {
        $count = Course::count();
        $course = Course::create([
            "title" => $data["title"],
            "description" => $data["description"],
            "module_id" => $moduleId,
            "order" => $count,
            "user_id" => Auth::user()->id
        ]);

        return $course;
    }
}
