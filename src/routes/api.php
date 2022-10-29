<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginApiController;
use App\Http\Controllers\Auth\LogoutApiController;
use App\Http\Controllers\Auth\RegisterApiController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;

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

    Route::middleware("permission:add-module")->post("/", [ModuleController::class, "store"])->name("module.create");
    Route::middleware("permission:edit-module")->put("/{id}", [ModuleController::class, "update"])->name("module.update");
    Route::middleware("permission:delete-module")->delete("/{id}", [ModuleController::class, "destroy"])->name("module.delete");
    Route::middleware("permission:view-module")->get("/{id}", [ModuleController::class, "show"])->name("module.showone");
    Route::middleware("permission:view-module")->get("/", [ModuleController::class, "index"])->name("module.showall");
    Route::middleware("permission:join-module")->post("/{id}/join", [ModuleController::class, "joinModule"])->name("module.join");
    Route::middleware("permission:add-module")->post("/{moduleId}/image", [ImageController::class, "saveModuleImage"])->name("module.createimage");
});

Route::prefix("module/{id1}/course")->middleware("auth:sanctum")->group(function () {

    Route::middleware("permission:view-course")->get("/", [CourseController::class, "index"])->name("course.showall");
    Route::middleware("permission:view-course")->get("/{id2}", [CourseController::class, "show"])->name("course.showone");
    Route::middleware("permission:add-course")->post("/", [CourseController::class, "store"])->name("course.create");
    Route::middleware("permission:edit-course")->put("/{id2}", [CourseController::class, "update"])->name("course.update");
    Route::middleware("permission:delete-course")->delete("/{id2}", [CourseController::class, "destroy"])->name("course.delete");
});

Route::prefix("course/{courseId}/quiz")->middleware("auth:sanctum")->group(function () {

    Route::middleware("permission:view-quiz")->get("/", [QuizController::class, "index"])->name("quiz.showall");
    Route::middleware("permission:view-quiz")->get("/{quizId}", [QuizController::class, "show"])->name("quiz.showone");
    Route::middleware("permission:add-quiz")->post("/", [QuizController::class, "store"])->name("quiz.create");
    Route::middleware("permission:edit-quiz")->put("/{quizId}", [QuizController::class, "update"])->name("quiz.update");
    Route::middleware("permission:delete-quiz")->delete("/{quizId}", [QuizController::class, "destroy"])->name("quiz.delete");
});

Route::prefix("quiz/{quizId}/question")->middleware("auth:sanctum")->group(function () {

    Route::middleware("permission:view-question")->get("/", [QuestionController::class, "index"])->name("question.showall");
    Route::middleware("permission:view-question")->get("/{questionId}", [QuestionController::class, "show"])->name("question.showone");
    Route::middleware("permission:add-question")->post("/", [QuestionController::class, "store"])->name("question.create");
    Route::middleware("permission:edit-question")->put("/{questionId}", [QuestionController::class, "update"])->name("question.update");
    Route::middleware("permission:delete-question")->delete("/{questionId}", [QuestionController::class, "destroy"])->name("question.delete");
});

Route::prefix("question/{questionId}/choice")->middleware("auth:sanctum")->group(function () {

    Route::middleware("permission:view-choice")->get("/", [ChoiceController::class, "index"])->name("choice.showall");
    Route::middleware("permission:view-choice")->get("/{choiceId}", [ChoiceController::class, "show"])->name("choice.showone");
    Route::middleware("permission:add-choice")->post("/", [ChoiceController::class, "store"])->name("choice.create");
    Route::middleware("permission:edit-choice")->put("/{choiceId}", [ChoiceController::class, "update"])->name("choice.update");
    Route::middleware("permission:delete-choice")->delete("/{choiceId}", [ChoiceController::class, "destroy"])->name("choice.delete");
});




Route::middleware('auth:sanctum')->post('/logout', [LogoutApiController::class, 'store'])->name('logout');
Route::post('/login', [LoginApiController::class, 'store'])->name('login');
Route::post('/register', [RegisterApiController::class, 'store'])->name('registerapi');
