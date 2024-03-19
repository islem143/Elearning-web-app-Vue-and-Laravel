<?php

namespace App\Modules\Module;

use App\Enums\Roles;
use App\Models\Module;
use App\Modules\Course\CourseService;
use Illuminate\Support\Facades\Auth;

class ModuleService
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }
    public function getAll($categoryFilter, $titleFilter, $studentId = null)
    {
        $compltedCourses = null;
        $modules = Module::where("title", 'like', "%" . $titleFilter . "%")
            ->withCount(["courses as total_courses", "users as total_users"])
            ->with(["courses", 'createdBy'])
            ->when($categoryFilter, function ($query, $categoryFilte) {
                $query->whereIn("category_id", $categoryFilte);
            });
        if ($studentId) {
            [$modules, $compltedCourses] = $this->filterStudentModules($modules, $studentId);
        }
        $modules = $modules->paginate(10);
        
        $modules["completed_courses"] = $compltedCourses;
        return $modules;
    }
    public function filterStudentModules($modules, $studentId)
    {

        $modules = $modules->with(["users" => function ($query) use ($studentId) {
            $query->where('id', $studentId);
        }]);

        $modules_ids = $modules->pluck("id");
        $compltedCourses = $this->courseService->getCompletedCourses($modules_ids);

        return [$modules, $compltedCourses];
    }
    public function getStudentModules($studentId, $filters)
    {

        $modules = Module::with("courses")
            ->join("module_user", 'modules.id', '=', 'module_user.module_id')
            ->where('module_user.user_id', $studentId)
            ->with(["courses", 'createdBy'])
            ->where("title", 'like', "%" . $filters["title"] . "%")
            ->when($filters["categories"], function ($query, $filters) {
                $query->whereIn("category_id", $filters["categories"]);
            })
            ->paginate(10);




        return $modules;
    }
}
