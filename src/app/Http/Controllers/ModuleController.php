<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Category;

use App\Models\Module;

use App\Modules\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Modules\Course\CourseService;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/api/users",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    protected $courseService;
    protected $categoryService;
    public function __construct(CourseService $courseService, CategoryService $categoryService)
    {
        $this->courseService = $courseService;
        $this->categoryService = $categoryService;
    }
    public function getAllModules(Request $request)

    {
        $categories = $request->query('categories');
        $title = $request->query("title");
        $modules = Module::where("title", 'like', "%" . $request->query("title") . "%")
            ->withCount(["courses as total_courses"])
            ->with(["courses", 'createdBy'])
            ->when($categories, function ($query, $categories) {
                $query->whereIn("category_id", $categories);
            })
            ->paginate(10);
        return response()->json(["modules" => $modules]);
    }
    public function index(Request $request)

    {

        $this->authorize("view", Module::class);
        $categories = $request->query('categories');
        $title = $request->query("title");

        $modules = Module::with(["courses", 'createdBy'])
            ->withCount(["courses as total_courses", "users as total_users"])
            ->with(["category"])
            ->where("title", 'like', "%" . $title . "%")
            ->when($categories, function ($query, $categories) {
                $query->whereIn("category_id", $categories);
            });

        if (Auth::user()->hasRole([Roles::STUDENT->value, Roles::SUPER_ADMIN->value])) {
            $modules = $modules->with(["users" => function ($query) {
                $query->where('id', Auth::user()->id);
            }]);
            $modules_ids = $modules->pluck("id");
            $compltedCourses = $this->courseService->getCompletedCourses($modules_ids);
        }
        if (Auth::user()->hasRole([Roles::TEACHER->value])) {
            $modules = $modules->where("user_id", Auth::user()->id);
        }
        $modules = $modules->paginate(10);
        $res = ["modules" => $modules];
        if (Auth::user()->hasRole(["student", "super-admin"])) {
            $modules["completed_courses"] = $compltedCourses;
        }
        return response()->json($res);
    }
    public function count()
    {
        if (!Auth::user() || Auth::user()->hasRole([Roles::STUDENT->value, Roles::SUPER_ADMIN->value])) {
            return   response()->json(["count" => Module::count()]);
        } else {
            return   response()->json(["count" => Module::where("user_id", Auth::user()->id)->count()]);
        }
    }
    public function compledtedCourses(Request $request, $id)
    {

        $totalCourses = Module::find($id)->courses->count();
        $compltedCourses = DB::table("courses")
            ->join("course_users", "courses.id", "=", "course_users.course_id")
            ->where(["module_id" => $id, "course_users.user_id" => Auth::user()->id, "staus" => "completed"])
            ->count();
        return response()->json(["totalCourse" => $totalCourses, "completedCourses" => $compltedCourses]);
    }
    public function joinModule($id)
    {

        $module = Module::FindOrFail($id);
        $can_join_module = Gate::inspect('joinModule', $module);
        if ($can_join_module->allowed()) {

            Auth::user()->modules()->attach($module->id);
            return response()->json(["message" => "student added to module"], 201);
        }
        return response()->json(["message" => $can_join_module->message()], 403);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize("create", Module::class);
        $this->validate($request, [
            "title" => "required",
            "description" => "required",

        ]);
        $payload = [
            "title" => $request->title,
            "descprtion" => $request->description,
            "user_id" => Auth::user()->id,
            "rating" => 0
        ];
        if ($request->has("category")) {
            $this->authorize("create", Category::class);

            if (array_key_exists("id", $request["category"])) {
                $category_id = $request["category"]["id"];
                $category = $this->categoryService->getCategory($category_id);
            } else {
                $category_name = $request["category"]["name"];
                $category = $this->categoryService->createCategory($category_name, Auth::user()->id);
            }

            $payload["category_id"] = $category->id;
        }

        $module = Module::create($payload);
        return $module;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize("view", Module::class);

        return Module::where(["id" => $id])->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);
        $this->authorize("update", $module);
        $module->update($request->all());
        return $module;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $this->authorize("delete", $module);
        $module->delete();
        return response()->json(["module deleted succesfully"]);
    }
    public function join(Request $request)
    {
        $module = Auth::user()->modules()->where("module_id", $request->moduleId)->first();

        if ($module) {
            return response()->json(["message" => "your already enroled to this module"], 403);
        } else {
            Auth::user()->modules()->attach($request->moduleId);
            return response()->json(["message" => "you have succesfully"]);
        }
    }
    public function myModules(Request $request)
    {

        return Module::with("courses")
            ->join("module_user", 'modules.id', '=', 'module_user.module_id')
            ->where('module_user.user_id', Auth::user()->id)
            ->where("title", 'like', "%" . $request->query("title") . "%")
            ->paginate(10);
    }
}
