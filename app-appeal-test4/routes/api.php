<?php

use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\FrontUserController;
use App\Http\Controllers\PasswordResetController;
use App\Models\FrontUser;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::post('employee/login', [EmployeeController::class, 'login']);
Route::post('employee/register', [EmployeeController::class, 'register']);
Route::get('test', [EmployeeController::class, 'CountGrah']);
/* route::get('employee/details',[EmployeeController::class,'employeeDetails'])->middleware(['auth:sanctum', 'ability:employee']); */

Route::group(['middleware' => 'auth:sanctum', 'ability:employee'], function () {
    Route::get('employee/details', [EmployeeController::class, 'employeeDetails']);
    Route::get('employee/logout', [EmployeeController::class, 'logout']);
    Route::put('employee/update', [EmployeeController::class, 'employeeUpdate']);
    Route::get('employee/appeal/details', [EmployeeController::class, 'EmApperDetails']);
    Route::delete('employee/delete/{id}', [EmployeeController::class, 'employeeDelete']);
    Route::get('/employee/appeal/{app_doc}', [EmployeeController::class, 'getAppealByAppDocEm']);
    Route::get('/employee/appeal2/{app_id}', [EmployeeController::class, 'getAppealByAppid']);
    Route::get('/employee/department', [EmployeeController::class, 'getdepartment']);

    Route::post('/create/comment/{app_id}', [EmployeeController::class, 'updateStatusandComment']);
    Route::post('/update/comment/{app_id}', [EmployeeController::class, 'closeappeal']);
    Route::post('/reject/appeal/{app_id}', [EmployeeController::class, 'rejectappeal']);
    Route::post('/return/appeal/{app_id}', [EmployeeController::class, 'returnappeal']);
    Route::post('/sendto/appeal/{app_id}', [EmployeeController::class, 'sendtoappeal']);
});



Route::post('user/login', [FrontUserController::class, 'login']);
Route::post('user/register', [FrontUserController::class, 'register']);
Route::post('/sendreset', [PasswordResetController::class, 'SentResetPasswordMail']);
Route::post('/reset/{token}', [PasswordResetController::class, 'resetpassword']);
Route::post('user/getcode', [FrontUserController::class, 'searchappdoc']);

Route::post('user/appeal', [FrontUserController::class, 'addAppeal']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user/details', [FrontUserController::class, 'userDetails']);
    Route::post('user/logout', [FrontUserController::class, 'logout']);
    Route::get('user/appeal/details', [FrontUserController::class, 'ApperDetails']);
    Route::get('/user/appeal/{app_doc}', [FrontUserController::class, 'getAppealByAppDoc']);
});



Route::get('login', function () {
    return view('welcome');
});
