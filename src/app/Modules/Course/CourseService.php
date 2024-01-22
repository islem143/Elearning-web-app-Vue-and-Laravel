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

        $courses=Course::where("module_id",$moduleId)->with(["courseUsers"=>function($query){
            $query->where("user_id",Auth::user()->id);
        },"media","quizzes"=>function($query){
            $query->with(["quizUsers"=>function($query){
                $query->where("user_id",Auth::user()->id);
            }]);
        }])->get();
    

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
