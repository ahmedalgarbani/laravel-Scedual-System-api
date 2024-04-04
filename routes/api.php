<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\Department_lecturerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\lecturer_subjectController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TimestableController;
use App\Http\Controllers\UserController;
use App\Http\Resources\LecturerSubjectResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//---------Rooms----------//
Route::get('rooms',[RoomController::class,'index']);
Route::get('room/{id}',[RoomController::class,'show']);
Route::post('room',[RoomController::class,'store']);
Route::put('room/{id}',[RoomController::class,'update']);
Route::delete('room/{id}',[RoomController::class,'destroy']);
//---------Rooms----------//

//---------lecturers----------//
Route::get('lecturers',[LecturerController::class,'index']);
Route::get('lecturer/{id}',[LecturerController::class,'show']);
Route::post('lecturer',[LecturerController::class,'store']);
Route::put('lecturer/{id}',[LecturerController::class,'update']);
Route::delete('lecturer/{id}',[LecturerController::class,'destroy']);
//---------lecturers----------//

 //---------students----------//
Route::get('students',[StudentController::class,'index']);
Route::get('student/{id}',[StudentController::class,'show']);
Route::post('student',[StudentController::class,'store']);
Route::put('student/{id}',[StudentController::class,'update']);
Route::delete('student/{id}',[StudentController::class,'destroy']);
//---------students----------//

 //---------colleges----------//
Route::get('colleges',[CollegeController::class,'index']);
Route::get('college/{id}',[CollegeController::class,'show']);
Route::post('college',[CollegeController::class,'store']);
Route::put('college/{id}',[CollegeController::class,'update']);
Route::delete('college/{id}',[CollegeController::class,'destroy']);
//---------colleges----------//


////---------subjects----------//
Route::get('subjects',[SubjectController::class,'index']);
Route::get('subject/{id}',[SubjectController::class,'show']);
Route::post('subject',[SubjectController::class,'store']);
Route::put('subject/{id}',[SubjectController::class,'update']);
Route::delete('subject/{id}',[SubjectController::class,'destroy']);
//---------subjects----------//


 ////---------semesters----------//
Route::get('semesters',[SemesterController::class,'index']);
Route::get('semester/{id}',[SemesterController::class,'show']);
Route::post('semester',[SemesterController::class,'store']);
Route::put('semester/{id}',[SemesterController::class,'update']);
Route::delete('semester/{id}',[SemesterController::class,'destroy']);
//---------semesters----------//

 ////---------timestable----------//
Route::get('timestables',[TimestableController::class,'index']);
Route::get('timestable/{id}',[TimestableController::class,'show']);
Route::post('timestable',[TimestableController::class,'store']);
Route::put('timestable/{id}',[TimestableController::class,'update']);
Route::delete('timestable/{id}',[TimestableController::class,'destroy']);


Route::get('search/{param}',[TimestableController::class,'search']);

//---------timestable----------//

 ////---------lecturer_subject----------//
Route::get('lecturer_subjects',[lecturer_subjectController::class,'index']);
Route::get('lecturer_subject/{id}',[lecturer_subjectController::class,'show']);
Route::post('lecturer_subject',[lecturer_subjectController::class,'store']);
Route::put('lecturer_subject/{id}',[lecturer_subjectController::class,'update']);
Route::delete('lecturer_subject/{id}',[lecturer_subjectController::class,'destroy']);
//---------lecturer_subject----------//

 ////---------department_lecturer----------//
Route::get('department_lecturers',[Department_lecturerController::class,'index']);
Route::get('department_lecturer/{id}',[Department_lecturerController::class,'show']);
Route::post('department_lecturer',[Department_lecturerController::class,'store']);
Route::put('department_lecturer/{id}',[Department_lecturerController::class,'update']);
Route::delete('department_lecturer/{id}',[Department_lecturerController::class,'destroy']);
//---------department_lecturer----------//


////---------departments----------//
Route::get('departments',[DepartmentController::class,'index']);
Route::get('department/{id}',[DepartmentController::class,'show']);
Route::post('department',[DepartmentController::class,'store']);
Route::put('department/{id}',[DepartmentController::class,'update']);
Route::delete('department/{id}',[DepartmentController::class,'destroy']);
//---------departments----------//

////---------users----------//
Route::get('users',[UserController::class,'index']);
Route::get('user/{id}',[UserController::class,'show']);
Route::post('user',[UserController::class,'register']);
Route::put('user/{id}',[UserController::class,'update']);
Route::delete('user/{id}',[UserController::class,'destroy']);
//---------users----------//



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
