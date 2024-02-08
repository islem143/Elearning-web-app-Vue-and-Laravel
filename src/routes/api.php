<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginApiController;
use App\Http\Controllers\Auth\LogoutApiController;
use App\Http\Controllers\Auth\RegisterApiController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VereficationController;
use App\Models\Course;
use App\Models\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("email-verification",[VereficationController::class,"verify"])->name("verification.verify");

Route::get("modules", [ModuleController::class, "getAllModules"])->name("module.getAllModules");
Route::get("module/count", [ModuleController::class, "count"])->name("module.count");

Route::prefix("module")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [ModuleController::class, "index"])->name("module.showall");
    Route::get("/myModules", [ModuleController::class, "myModules"])->name("module.showmymodules");
    Route::get("/{id}/completedCourses", [ModuleController::class, "compledtedCourses"])->name("course.compledtedCourses");

    Route::post("/", [ModuleController::class, "store"])->name("module.create");
    Route::post("/join", [ModuleController::class, "join"])->name("module.join");
    Route::put("/{id}", [ModuleController::class, "update"])->name("module.update");
    Route::delete("/{id}", [ModuleController::class, "destroy"])->name("module.delete");
    Route::get("/{id}", [ModuleController::class, "show"])->name("module.showone");
    Route::post("/{id}/join", [ModuleController::class, "joinModule"])->name("module.join2");
    Route::post("/{moduleId}/image", [ImageController::class, "saveModuleImage"])->name("module.createimage");
});
Route::prefix("logs")->middleware("auth:sanctum")->group(function () {
    Route::middleware("can:view-logs")->get("/", [LogController::class, "index"])->name("logs.show");
});

Route::prefix("users")->middleware("auth:sanctum")->group(function () {
    Route::middleware("can:view-users")->get("/", [LogController::class, "index"])->name("logs.showusers");
});

Route::prefix("courses")->middleware("auth:sanctum")->group(function(){
    Route::get("/completed", [CourseController::class, "compledtedCourses"])->name("course.compledtedCourses");
});
Route::prefix("module/{id1}/course")->middleware("auth:sanctum")->group(function () {

    Route::post("/{id2}/content", [CourseController::class, "storeContent"])->name("course.storeContent");
    Route::post("/{id2}/startCourse", [CourseController::class, "startCourse"])->name("course.startCourse");
    Route::get("/", [CourseController::class, "index"])->name("course.showall");
    Route::get("/{id2}", [CourseController::class, "show"])->name("course.showone");
    Route::post("/", [CourseController::class, "store"])->name("course.create");
    Route::put("/{id2}", [CourseController::class, "update"])->name("course.update");
    Route::delete("/{id2}", [CourseController::class, "destroy"])->name("course.delete");
});

Route::prefix("course/{courseId}/quiz")->middleware("auth:sanctum")->group(function () {

    Route::get("/", [QuizController::class, "index"])->name("quiz.showall");
    Route::get("/{quizId}/doneQuiz", [QuizController::class, "doneQuiz"])->name("quiz.doneQuiz");
    Route::get("/{quizId}", [QuizController::class, "show"])->name("quiz.showone");
    Route::post("/", [QuizController::class, "store"])->name("quiz.create");
    Route::put("/{quizId}", [QuizController::class, "update"])->name("quiz.update");
    Route::put("/{quizId}/saveResult", [QuizController::class, "saveResult"])->name("quiz.saveResult");

    Route::delete("/{quizId}", [QuizController::class, "destroy"])->name("quiz.delete");
});
Route::prefix("quiz/{quizId}/question")->middleware("auth:sanctum")->group(function () {

    Route::get("/", [QuestionController::class, "index"])->name("question.showall");
    Route::get("/{questionId}", [QuestionController::class, "show"])->name("question.showone");
    Route::post("/", [QuestionController::class, "store"])->name("question.create");
    Route::put("/{questionId}", [QuestionController::class, "update"])->name("question.update");
    Route::delete("/{questionId}", [QuestionController::class, "destroy"])->name("question.delete");
});

Route::prefix("question/{questionId}/choice")->middleware("auth:sanctum")->group(function () {

    Route::middleware("can:view-choice")->get("/", [ChoiceController::class, "index"])->name("choice.showall");
    Route::middleware("can:view-choice")->get("/{choiceId}", [ChoiceController::class, "show"])->name("choice.showone");
    Route::middleware("can:add-choice")->post("/", [ChoiceController::class, "store"])->name("choice.create");
    Route::middleware("can:edit-choice")->put("/", [ChoiceController::class, "update"])->name("choice.update");
    //Route::middleware("can:add-choice")->post("/", [ChoiceController::class, "storeOne"])->name("choice.createOne");
    Route::middleware("can:attach-choice")->put("/{choiceId}/attach", [ChoiceController::class, "attach"])->name("choice.attach");

    Route::middleware("can:delete-choice")->delete("/{choiceId}", [ChoiceController::class, "destroy"])->name("choice.delete");
});


Route::prefix("media")->middleware("auth:sanctum")->group(function () {

    Route::middleware("can:view-media")->get("/{courseId}", [MediaController::class, "index"])->name("media.showall");
    // Route::middleware("can:view-media")->get("/{courseId}", [MediaController::class, "index"])->name("media.showone");
    Route::middleware("can:add-media")->post("/", [MediaController::class, "store"])->name("media.create");
    Route::middleware("can:edit-media")->put("/{choiceId}", [MediaController::class, "update"])->name("media.update");
    Route::middleware("can:delete-media")->delete("/{id}", [MediaController::class, "destroy"])->name("media.delete");
});


Route::middleware('auth:sanctum')->post('/logout', [LogoutApiController::class, 'store'])->name('logout');
Route::post('/login', [LoginApiController::class, 'store'])->name('login');
Route::post('/register', [RegisterApiController::class, 'store'])->name('registerapi');

Route::prefix("users")->middleware("auth:sanctum")->group(function () {

    // users
    Route::get("/", [UserController::class, 'index'])->middleware("auth:sanctum");
    Route::put("/{id}", [UserController::class, 'update'])->middleware("auth:sanctum");
    Route::post("/image", [UserController::class, 'image'])->middleware("auth:sanctum");
    //admin
    Route::post("/", [UserController::class, 'store'])->middleware("auth:sanctum");
    Route::delete("/{id}", [UserController::class, 'destroy'])->middleware("auth:sanctum");
});



Route::middleware("auth:sanctum")->group(function(){

    Route::get('/admin/stats', [App\Http\Controllers\StatsController::class, 'AdminDashboardStats'])->middleware("auth:sanctum");
    Route::get('/teacher/stats', [App\Http\Controllers\StatsController::class, 'TeacherDashboardStats'])->middleware("auth:sanctum");
    
});
Route::get('/chat', [App\Http\Controllers\ChatsController::class, 'index'])->middleware("auth:sanctum");
Route::get('/messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages'])->middleware("auth:sanctum");
Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage'])->middleware("auth:sanctum");
