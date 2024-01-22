<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Media;
use App\Models\Message;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ModuleUserTable;

class StatsController extends Controller
{


    public function AdminDashboardStats(Request $request)
    {
        if (Auth::user()->getRoleNames()[0] == "super-admin") {
            $userCount = User::count();
            $coursesCount = Course::count();
            $messagesCount = Message::count();
            $res = [
                "users" => $userCount,
                "coursesCount" => $coursesCount,
                "messagesCount" => $messagesCount
            ];
            return response()->json($res, 200);
        } else {
            return response()->json([], 403);
        }
    }
    public function TeacherDashboardStats(Request $request)
    {
        if (Auth::user()->getRoleNames()[0] == "teacher") {
            $modulesCount = Module::where("user_id", Auth::user()->id)->count();
 
             $totalStudents=DB::table("module_user")->whereIn("module_id",function($query){
                $query->select("id")->from("modules")->where("user_id",Auth::user()->id);
             })->select(DB::raw("count(DISTINCT module_user.user_id) as totalStudents"))->first();
             $totalQuizzes=Quiz::where("created_by",Auth::user()->id)->count();
             $totalCourses=Course::where("user_id",Auth::user()->id)->count();
             $totalMedia=Media::where("created_by",Auth::user()->id)->count();

  
            $pieChart = DB::table("modules")
            ->join("module_user", "modules.id", "=", "module_user.module_id")
            ->where("modules.user_id", Auth::user()->id)
            ->select(DB::raw('modules.id ,modules.title as label,count(*) as totalStudents'))
            ->groupBy("modules.id")
            ->limit(4)
            ->get();
            $modulesStudentPieChart["labels"]=$pieChart->pluck("label");
            $modulesStudentPieChart["data"]=$pieChart->pluck("totalStudents");
          
            $res = [
                "modules" => $modulesCount,
                "students" => $totalStudents->totalStudents,
                "moduleStudentPie"=>$modulesStudentPieChart,
                "totalQuizzes"=>$totalQuizzes,
                "totalCourses"=>$totalCourses,
                "totalMedia"=>$totalMedia

            ];
            return response()->json($res, 200);
        } else {
            return response()->json([], 403);
        }
    }
}
