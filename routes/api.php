<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacancyController;
use App\Models\User;
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

Route::group(['middleware'=>["auth:api"]], function(){
    Route::post("create-company", [CompanyController::class, "createCompany"]);
    Route::post("create-sector", [CompanyController::class, "createSector"]);
    Route::get("get-sectors", [CompanyController::class, "getSectors"]);
    Route::get("get-companies", [CompanyController::class, "getCompaniesList"]);
    Route::get("get-company-details/{id}", [CompanyController::class, "getCompanyDetails"]);
    Route::post("create-job", [VacancyController::class, "createVacancy"]);
    Route::get("get-jobs",[VacancyController::class, "getJobList"]);
    Route::post("create-company-size", [CompanyController::class, "createCompanySize"]);
    Route::get("company-size", [CompanyController::class, "getCompanySize"]);
    Route::post("update-company", [CompanyController::class, "updateCompanyProfile"]);

    Route::post("create-country", [CountryController::class, "createCountry"]);
    Route::get("get-countries", [CountryController::class, "getCountry"]);
    Route::get("get-country-by-id/{id}", [CountryController::class, "getCountryById"]);
    Route::post("create-region", [CountryController::class, "createRegion"]);

    Route::get("get-region", [CountryController::class, "getRegions"]);
    Route::get("get-region-by-id/{id}", [CountryController::class, "getRegionsById"]);
    Route::get("get-region-by-country-id/{countryId}", [CountryController::class, "getRegionsByCountryId"]);

    Route::post("create-city", [CountryController::class, "createCity"]);
    Route::get("get-cities", [CountryController::class, "getCities"]);
    Route::get("get-cities-by-id/{id}", [CountryController::class, "getCitiesById"]);
    Route::get("get-cities-by-region-id/{regionId}", [CountryController::class, "getCitiesByRegionId"]);
    Route::get("get-cities-by-country-id/{countryId}", [CountryController::class, "getCitiesByCountryId"]);
    Route::post("update-user-profile", [UserController::class, "updateUserProfile"]);
    Route::get("get-company-profile/{id}", [CompanyController::class, "getCompanyProfile"]);
    Route::get("get-user-profile/{id}", [UserController::class, "getUserProfile"]);
    Route::get("get-company-jobs/{id}", [CompanyController::class, "getCompanyJobs"]);
    Route::get("get-user-company-details", [CompanyController::class, "getUserCompanyDetails"]);
    Route::get("get-company-job", [CompanyController::class, "getUserCompanyJobs"]);

 });


