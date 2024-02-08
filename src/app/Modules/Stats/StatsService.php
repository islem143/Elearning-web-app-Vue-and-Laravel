<?php

namespace App\Modules\Stats;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatsService
{
    
    public function TeacherDashboardStats(Request $request)
    {
       
            $modulesCount = Module::where("user_id", Auth::user()->id)->count();

            $totalStudents = DB::table("module_user")->whereIn("module_id", function ($query) {
                $query->select("id")->from("modules")->where("user_id", Auth::user()->id);
            })->select(DB::raw("count(DISTINCT module_user.user_id) as totalStudents"))->first();
            $totalQuizzes = Quiz::where("created_by", Auth::user()->id)->count();
            $totalCourses = Course::where("user_id", Auth::user()->id)->count();
            $totalMedia = Media::where("created_by", Auth::user()->id)->count();


            $barChart = DB::table("modules")
                ->join("module_user", "modules.id", "=", "module_user.module_id")
                ->where("modules.user_id", Auth::user()->id)
                ->select(DB::raw('count(id) as `count_students`'),DB::raw('YEAR(module_user.created_at) year, MONTH(module_user.created_at) month'))
                ->groupby('year', 'month')
                ->get();

            $pieChart = DB::table("modules")
                ->join("module_user", "modules.id", "=", "module_user.module_id")
                ->where("modules.user_id", Auth::user()->id)
                ->select(DB::raw('modules.id ,modules.title as label,count(*) as totalStudents'))
                ->groupBy("modules.id")
                ->limit(4)
                ->get();
            $modulesStudentPieChart["labels"] = $pieChart->pluck("label");
            $modulesStudentPieChart["data"] = $pieChart->pluck("totalStudents");

            $res = [
                "modules" => $modulesCount,
                "students" => $totalStudents->totalStudents,
                "moduleStudentPie" => $modulesStudentPieChart,
                "totalQuizzes" => $totalQuizzes,
                "totalCourses" => $totalCourses,
                "totalMedia" => $totalMedia,
                "barChart" => $barChart

            ];
            return response()->json($res, 200);
        
    
 

        }
}
