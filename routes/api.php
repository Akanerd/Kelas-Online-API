<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\StudentController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('category', [CategoryController::class, 'getall']);
Route::post('login', [StudentController::class, 'login']);
Route::post('course-by-category',[CourseController::class,'getByCategory']);
Route::post('course-by-id',[CourseController::class,'getById']);
Route::post('module-by-id',[ModuleController::class,'ModuleById']);
Route::get('course',[CourseController::class,'index']);