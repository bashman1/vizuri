<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/vizuri', function () {
    return ["api"=>"Api works perfects"];
});

Route::post("create-user", [UserController::class, "createUser"]);
Route::post("login", [UserController::class, "login"]);
Route::post("create-company", [CompanyController::class, "createCompany"]);
Route::post("create-sector", [CompanyController::class, "createSector"]);
Route::get("get-sectors", [CompanyController::class, "getSectors"]);
Route::get("get-companies", [CompanyController::class, "getCompaniesList"]);
Route::get("get-company-details/{id}", [CompanyController::class, "getCompanyDetails"]);
