<?php

use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'auth'],function(){
    Route::group(['middleware' => 'admin'],function(){
        Route::prefix('/admin')->group(function(){
            Route::get('/', function () {
                return view('admin.dashboard');
            })->name('admin.dashboard');
        
            // ------------------------- SCHOOL ------------------------
            Route::post('/schools','admin\SchoolController@store')->name('admin.school.store');
            Route::delete('/schools/{id}','admin\SchoolController@destroy')->name('admin.school.destroy');
            // --------------------------END SCHOOL---------------------------
        
            // ------------------------- STUDENT ------------------------------
            Route::get('/users','admin\UserController@user')->name('admin.users.index');
            Route::get('/users/create','admin\UserController@create')->name('admin.users.create');
            Route::post('/users','admin\UserController@store')->name('admin.users.store');
            Route::get('/users/show/{id}','admin\UserController@show')->name('admin.users.show');
            Route::match(['put','patch'],'/users/{id}','admin\UserController@edit')->name('admin.users.edit');
            Route::delete('/users/{id}','admin\UserController@destroy')->name('admin.users.destroy');
            // ------------------------ END STUDENT ------------------------
        
        
            // ------------------------ POSITION -----------------------------------------------
            Route::post('/position','admin\PositionController@store')->name('admin.position.store');
            Route::delete('/position/{id}','admin\PositionController@destroy')->name('admin.position.destroy');
            // ------------------------- END POSITION ---------------------------------------
        
            //------------------------- MENTOR ----------------------------
            Route::get('/mentors','admin\MentorController@index')->name('admin.mentors.index');
            Route::get('mentors/create','admin\MentorController@create')->name('admin.mentors.create');
            Route::post('/mentors','admin\MentorController@store')->name('admin.mentors.store');
            Route::get('/mentors/show/{id}','admin\MentorController@show')->name('admin.mentors.show');
            Route::match(['put','patch'],'/mentors/{id}','admin\MentorController@edit')->name('admin.mentors.edit');
            Route::delete('/mentors/{id}','admin\MentorController@destroy')->name('admin.mentors.destroy');
            // -------------------------- END MENTOR ----------------------
        
            // -------------------- INSTRUCTOR ------------------------
            Route::get('/instructors','admin\InstructorController@index')->name('admin.instructors.index');
            Route::post('/instructors','admin\InstructorController@store')->name('admin.instructors.store');
            Route::match(['put','patch'],'/instructors/{id}','admin\InstructorController@edit')->name('admin.instructors.edit');
            Route::delete('/instructors/{id}','admin\InstructorController@destroy')->name('admin.instructor.destroy');
            // --------------------- END INSTRUCTOR ----------------------
        
            // --------------------- PROJECT ---------------------------------
            Route::get('/projects','admin\ProjectController@index')->name('admin.projects.index');
            Route::post('/projects','admin\ProjectController@store')->name('admin.projects.store');
            // ----------------------- END PROJECT ---------------------------
        });
    });

    // ----------------------------- MIDDLEWARE MENTOR -------------------
    Route::group(['middleware' => 'mentor'],function(){
        Route::prefix('/mentor')->group(function(){
            Route::get('/', function () {
                return view('mentor.dashboard');
            })->name('mentor.dashboard');

            Route::get('/review-student','mentor\ReviewController@index')->name('mentor.review.index');
            Route::match(['put','pacth'],'/review-student/{id}','mentor\ReviewController@review_student')->name('mentor.review_student');
            Route::delete('/review/student/{id}','mentor\ReviewController@delete_review')->name('mentor.review.delete');
        });
    });

    // ------------------------ MIDDLEWARE STUDENT -------------------
    Route::group(['middleware' => 'student'],function(){
        Route::prefix('/student')->group(function(){
            Route::get('/', function () {
                return view('student.dashboard');
            })->name('student.dashboard');

            Route::get('/project','student\ProjectController@index')->name('student.project.index');
            Route::post('/project','student\ProjectController@store')->name('student.project.store');
            Route::match(['put','patch'],'/project/{id}','student\ProjectController@edit')->name('student.project.edit');
        });
    });

    // ------------------------ MIDDLEWARE STUDENT -------------------
    Route::group(['middleware' => 'instructor'],function(){
        Route::prefix('/instructor')->group(function(){
            Route::get('/', function () {
                return view('instructor.dashboard');
            })->name('instructor.dashboard');

            Route::get('/review-student','instructor\ReviewController@index')->name('instructor.review_student.index');
        });
    });
});


Auth::routes();
