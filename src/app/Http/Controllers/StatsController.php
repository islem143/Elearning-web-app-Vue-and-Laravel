<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Message;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $studentCount = DB::table("modules")->join("module_user", "modules.id", "=", "module_user.module_id")->where("modules.user_id", Auth::user()->id)->count();

            $res = [
                "modules" => $modulesCount,
                "students" => $studentCount,


            ];
            return response()->json($res, 200);
        } else {
            return response()->json([], 403);
        }
    }
}
