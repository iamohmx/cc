<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HnUserController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\IncidentReportController;
use App\Http\Controllers\RccRoleController;
use App\Http\Controllers\RccUserController;
use App\Http\Controllers\ServiceAreaController;
use App\Http\Controllers\ServiceUnitController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\FastTrackUserController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceUnitVehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('password/reset/{token}', function ($token) {
    return redirect(config('app.frontend_url') . "/reset-password?token={$token}");
})->name('password.reset');

Route::post('report-incident', [IncidentReportController::class, 'report']);
Route::post('login',    [AuthController::class, 'login']);
Route::post('password/forgot', [AuthController::class, 'forgot']); // send reset link
Route::post('password/reset',  [AuthController::class, 'reset']);  // reset with token

// อ่านรายการทั้งหมด
Route::get('incidents',             [IncidentController::class, 'index']);
// อ่านทีละรายการ
Route::get('incidents/{incident}',  [IncidentController::class, 'show']);
// สร้างใหม่
Route::post('incidents',             [IncidentController::class, 'store']);

// ------hn_user------
Route::post('hn-login', [AuthController::class, 'hn_login']);
// ------fast_track_user------
Route::post('fst-login', [AuthController::class, 'fst_login']);

Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // แก้ไข
    Route::put('incidents/{incident}',  [IncidentController::class, 'update']);
    // ลบ
    Route::delete('incidents/{incident}',  [IncidentController::class, 'destroy']);

    // Role CRUD
    Route::apiResource('roles', RccRoleController::class);
    // User CRUD
    Route::apiResource('users', RccUserController::class);
    Route::get('profile', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Route::post('forgot-password', [AuthController::class, 'forgotPassword']);


    // ---hn_user---

    // ดึงข้อมูล profile ของตัวเอง
    Route::get('hn-user/profile', [HnUserController::class, 'profile']);
    // อัปเดตข้อมูล user + personal info
    Route::put('hn-user/profile', [HnUserController::class, 'updateProfile']);
    Route::post('hn-logout', [AuthController::class, 'hn_logout']);



    // Service Areas
    // Route::apiResource('service-areas', ServiceAreaController::class);
    Route::apiResource('areas', ServiceAreaController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    // Service Units
    // Route::apiResource('service-units', ServiceUnitController::class);
    // Route::post('service-units/{unit}/image', [ServiceUnitController::class, 'uploadImage']);
    Route::get('/service-units',            [ServiceUnitController::class, 'index']);
    Route::post('/service-units',            [ServiceUnitController::class, 'store']);
    Route::get('/service-units/{serviceUnit}', [ServiceUnitController::class, 'show']);
    Route::put('/service-units/{serviceUnit}', [ServiceUnitController::class, 'update']);
    Route::delete('/service-units/{serviceUnit}', [ServiceUnitController::class, 'destroy']);

    // Vehicle Types
    Route::apiResource('vehicle-types', VehicleTypeController::class);

    // Vehicles
    Route::apiResource('vehicles', VehicleController::class);
    Route::post('vehicles/{vehicle}/pdf',    [VehicleController::class, 'uploadPdf']);
    Route::post('vehicles/{vehicle}/images', [VehicleController::class, 'uploadImage']);

    // Employees (พนักงานรถฉุกเฉิน)
    // Route::apiResource('employees', EmployeeController::class);

    // Hospitals
    Route::apiResource('hospitals', HospitalController::class);

    // Missions รับภารกิจ / ยกเลิกภารกิจ
    // ดูรายการ mission แบบ pagination
    Route::get('missions', [MissionController::class, 'index']);
    // ดู mission ทีละ record
    Route::get('missions/{mission}', [MissionController::class, 'show']);
    // รับภารกิจใหม่
    Route::post('missions', [MissionController::class, 'accept']);
    // ยกเลิกภารกิจ
    Route::post('missions/{mission}/cancel', [MissionController::class, 'cancel']);

    Route::apiResource('fst-users', FastTrackUserController::class);

    Route::post('service-units/attach-vehicle', [ServiceUnitVehicleController::class, 'store']);
    Route::prefix('service-units/{serv_id}')->group(function () {
        Route::get('vehicles',             [ServiceUnitVehicleController::class, 'index']);
        Route::get('vehicles/{veh_id}',    [ServiceUnitVehicleController::class, 'show']);
        Route::put('vehicles/{veh_id}',    [ServiceUnitVehicleController::class, 'update']);
        Route::delete('vehicles/{veh_id}', [ServiceUnitVehicleController::class, 'destroy']);
    });

    // report
    Route::get('reports/summary', [ReportController::class, 'summary']);
    // ------fast_track_user------
    Route::post('fst-register', [AuthController::class, 'fst_register']);
});
// ---hn_incident---
// Route::apiResource('incidents', IncidentController::class);
