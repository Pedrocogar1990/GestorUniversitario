<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Api\Student\DashboardStudentController;
use App\Http\Controllers\Api\Professor\DashboardProfessorController;
use App\Http\Controllers\Api\{
    AuthController,
    CareerController,
    DashboardController,
    ProfessorController,
    StudentController,
    SubjectController,
    EnrollmentController,
    UserController
};


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['web'])->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user()->load('roles'));
    Route::get('/roles', fn() => Role::all());
});


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/dashboard-data', [DashboardController::class, 'index']);
    Route::apiResource('/students', StudentController::class);
    Route::apiResource('/careers', CareerController::class);
    Route::apiResource('/professors', ProfessorController::class);
    Route::apiResource('/subjects', SubjectController::class);
    Route::apiResource('/enrollments', EnrollmentController::class);
    Route::apiResource('/users', UserController::class);
});


Route::middleware(['auth:sanctum', 'role:student'])->group(function () {
    Route::get('/dashboard-students', [DashboardStudentController::class, 'index']);
});


Route::middleware(['auth:sanctum', 'role:professor'])->group(function () {
    Route::get('/dashboard-professors', [DashboardProfessorController::class, 'index']);
});
