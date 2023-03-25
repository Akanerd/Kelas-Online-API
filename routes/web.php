<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\ModuleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::match(["GET","POST"],"/register",function(){
    return redirect('/login');
})->name("register");

Route::group(['middleware'=>['auth']],function(){
    Route::view('templates','components.templates.default');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);
    
    Route::get('category/trash',[CategoryController::class,'trash'])->name('category.trash');
    Route::get('category/{category}/restore}',[CategoryController::class,'restore'])->name('category.restore');
    Route::delete('category/{category}/delete-permanent',[CategoryController::class,'deletePermanent'])->name('category.delete-permanent');
    Route::resource('category',CategoryController::class);
    
    Route::post('student/{student}/resetpassword',[studentController::class,'resetPassword'])->name('student.resetpassword');
    Route::resource('student',studentController::class);
    
    Route::get('course/trash',[CourseController::class,'trash'])->name('course.trash');
    Route::get('course/{course}/restore',[CourseController::class,'restore'])->name('course.restore');
    Route::get('course/{course}/download',[CourseController::class,'download'])->name('course.download');
    Route::delete('course/{course}/delete-permanent',[CourseController::class,'deletePermanent'])->name('course.delete-permanent');
    Route::resource('course', CourseController::class);
    
    Route::get('module',[ModuleController::class,'index'])->name('module');
    Route::get('module/{module}/detail',[ModuleController::class,'detail'])->name('module.detail');
    Route::get('module/{module}/create',[ModuleController::class,'create'])->name('module.create');
    Route::post('module/store',[ModuleController::class,'store'])->name('module.store');
    Route::get('module/{module}/edit',[ModuleController::class,'edit'])->name('module.edit');
    Route::put('module/{module}/update',[ModuleController::class,'update'])->name('module.update');
    Route::get('module/{module}/download',[ModuleController::class,'download'])->name('module.download');
    Route::get('module/{module}/show',[ModuleController::class,'show'])->name('module.show');
    Route::delete('module/{module}/destroy',[ModuleController::class,'destroy'])->name('module.destroy');
});
