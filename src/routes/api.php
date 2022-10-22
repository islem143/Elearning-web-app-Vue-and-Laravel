<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginApiController;
use App\Http\Controllers\Auth\RegisterApiController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;

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

Route::prefix("module")->middleware("auth:sanctum")->group(function(){
   
    Route::middleware("permission:add-module")->post("/",[ModuleController::class,"store"])->name("module.create");
    Route::middleware("permission:edit-module")->put("/{id}",[ModuleController::class,"update"])->name("module.update");
    Route::middleware("permission:delete-module")->delete("/{id}",[ModuleController::class,"destroy"])->name("module.delete");
    Route::middleware("permission:view-module")->get("/{id}",[ModuleController::class,"show"])->name("module.showone");
    Route::middleware("permission:view-module")->get("/",[ModuleController::class,"index"])->name("module.showall");
    Route::middleware("permission:join-module")->post("/{id}/join",[ModuleController::class,"joinModule"])->name("module.join");


});


Route::prefix("module/{id1}/course")->middleware("auth:sanctum")->group(function(){
   
    Route::middleware("permission:view-course")->get("/",[CourseController::class,"index"])->name("course.showall");
    Route::middleware("permission:view-course")->get("/{id2}",[CourseController::class,"show"])->name("course.showone");
    Route::middleware("permission:add-course")->post("/",[CourseController::class,"store"])->name("course.create");
    Route::middleware("permission:edit-course")->put("/{id2}",[CourseController::class,"update"])->name("course.update");
    Route::middleware("permission:delete-course")->delete("/{id2}",[CourseController::class,"destroy"])->name("course.delete");


});

Route::middleware('auth:sanctum')->post('/logout', [LogoutApiController::class, 'store'])->name('logout');
Route::post('/login', [LoginApiController::class, 'store'])->name('login');
Route::post('/register', [RegisterApiController::class, 'store'])->name('registerapi');

