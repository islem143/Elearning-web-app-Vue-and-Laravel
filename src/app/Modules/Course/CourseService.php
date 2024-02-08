<?php

namespace App\Modules\Course;

use App\Models\Course;
use App\Models\Media;
use App\Models\Module;
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

        $courses = Course::where(["module_id" => $moduleId])
        ->with(["media", "coursesContent", 
        "quizzes" => function ($query) {
            $query->where("created_by", Auth::user()->id);
        }])->where("user_id", Auth::user()->id)->get();
     
        return $courses;
    }

    public function getStudentCourses($moduleId)
    {

        $courses=Course::where("module_id",$moduleId)->with(["courseUser"=>function($query){
            $query->where("user_id",Auth::user()->id);
        },"media","quizzes"=>function($query){
            $query->with(["quizUser"]);
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

    public function getCompletedCourses($module_ids){
       
        $compltedCourses = DB::table("courses")
            ->join("course_users", "courses.id", "=", "course_users.course_id")
            ->whereIn("module_id", $module_ids)
            ->where(["course_users.user_id" => Auth::user()->id, "staus" => "completed"])
            ->groupBy("module_id")
            ->select(DB::raw("count(module_id) as completed_courses, module_id"))->get();
        
        return $compltedCourses;    
    }
}
