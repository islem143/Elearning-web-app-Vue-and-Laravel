<?php

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

Route::prefix("module")->middleware("auth:sanctum")->group(function () {
    Route::middleware("can:view-module")->get("/", [ModuleController::class, "index"])->name("module.showall");
    Route::middleware(["can:view-course", 'role:student'])->get("/{id}/completedCourses", [ModuleController::class, "compledtedCourses"])->name("course.compledtedCourses");
    Route::middleware("can:add-module")->post("/", [ModuleController::class, "store"])->name("module.create");
    Route::middleware("can:edit-module")->put("/{id}", [ModuleController::class, "update"])->name("module.update");
    Route::middleware("can:delete-module")->delete("/{id}", [ModuleController::class, "destroy"])->name("module.delete");
    Route::middleware("can:view-module")->get("/{id}", [ModuleController::class, "show"])->name("module.showone");
    Route::middleware("can:join-module")->post("/{id}/join", [ModuleController::class, "joinModule"])->name("module.join");
    Route::middleware("can:add-module")->post("/{moduleId}/image", [ImageController::class, "saveModuleImage"])->name("module.createimage");
});
Route::prefix("logs")->middleware("auth:sanctum")->group(function () {
    Route::middleware("can:view-logs")->get("/", [LogController::class, "index"])->name("logs.showall");
});

Route::prefix("module/{id1}/course")->middleware("auth:sanctum")->group(function () {

    Route::middleware("can:add-course")->post("/{id2}/content", [CourseController::class, "storeContent"])->name("course.storeContent");
    Route::middleware("can:view-course")->post("/{id2}/startCourse", [CourseController::class, "startCourse"])->name("course.startCourse");
    Route::middleware("can:view-course")->get("/", [CourseController::class, "index"])->name("course.showall");
    Route::middleware("can:view-course")->get("/{id2}", [CourseController::class, "show"])->name("course.showone");
    Route::middleware("can:add-course")->post("/", [CourseController::class, "store"])->name("course.create");
    Route::middleware("can:edit-course")->put("/{id2}", [CourseController::class, "update"])->name("course.update");
    Route::middleware("can:delete-course")->delete("/{id2}", [CourseController::class, "destroy"])->name("course.delete");
});

Route::prefix("course/{courseId}/quiz")->middleware("auth:sanctum")->group(function () {

    Route::middleware("can:view-quiz")->get("/", [QuizController::class, "index"])->name("quiz.showall");
    Route::middleware("can:view-quiz")->get("/{quizId}/doneQuiz", [QuizController::class, "doneQuiz"])->name("quiz.doneQuiz");
    Route::middleware("can:view-quiz")->get("/{quizId}", [QuizController::class, "show"])->name("quiz.showone");
    Route::middleware("can:add-quiz")->post("/", [QuizController::class, "store"])->name("quiz.create");
    Route::middleware("can:edit-quiz")->put("/{quizId}", [QuizController::class, "update"])->name("quiz.update");
    Route::middleware("can:save-quiz-result")->put("/{quizId}/saveResult", [QuizController::class, "saveResult"])->name("quiz.saveResult");

    Route::middleware("can:delete-quiz")->delete("/{quizId}", [QuizController::class, "destroy"])->name("quiz.delete");
});
Route::prefix("quiz/{quizId}/question")->middleware("auth:sanctum")->group(function () {

    Route::middleware("can:view-question")->get("/", [QuestionController::class, "index"])->name("question.showall");
    Route::middleware("can:view-question")->get("/{questionId}", [QuestionController::class, "show"])->name("question.showone");
    Route::middleware("can:add-question")->post("/", [QuestionController::class, "store"])->name("question.create");
    Route::middleware("can:edit-question")->put("/{questionId}", [QuestionController::class, "update"])->name("question.update");
    Route::middleware("can:delete-question")->delete("/{questionId}", [QuestionController::class, "destroy"])->name("question.delete");
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


Route::get('/chat', [App\Http\Controllers\ChatsController::class, 'index'])->middleware("auth:sanctum");
Route::get('/messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages'])->middleware("auth:sanctum");
Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage'])->middleware("auth:sanctum");
