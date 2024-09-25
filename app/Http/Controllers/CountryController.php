<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{

    public function createCountry(Request $request){
        try {
            DB::beginTransaction();
            $country = Country::create([
                "name"=>$request->name,
                "code"=>$request->code,
                "currency"=>$request->currency,
                "status"=>"Active",
                "created_on"=>Carbon::now()
            ]);
            DB::commit();
            return $this->genericResponse(true, "Country created successfully", 201, $country);

        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getCountry(){
        try {
            $country = Country::where("status", "Active")->get();
            return $this->genericResponse(true, "countries", 200, $country);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getCountryById($countryId){
        try {
            $country = Country::where(["id"=>$countryId, "status"=>"Active"])->get();
            return $this->genericResponse(true, "countries", 200, $country);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function createRegion(Request $request){
        try {
            DB::beginTransaction();
            $region = Region::create([
                "name"=>$request->name,
                "country_id"=>$request->country_id,
                "status"=>"Active",
                "created_on"=>Carbon::now(),
                // "name"=>$request->name,
            ]);

            DB::commit();
            return $this->genericResponse(true, "Region created successfully", 201, $region);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getRegions(){
        try {
            $regions = Region::where("status", "Active")->get();
            return $this->genericResponse(true, "Regions", 200, $regions);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getRegionsById($regionId){
        try {
            $regions = Region::where(["status"=>"Active", "id"=>$regionId])->get();
            return $this->genericResponse(true, "Regions", 200, $regions);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getRegionsByCountryId($countryId){
        try {
            $regions = Region::where(["status"=>"Active", "country_id"=>$countryId])->get();
            return $this->genericResponse(true, "Regions", 200, $regions);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function createCity(Request $request){
        try {
            DB::beginTransaction();
            $city = City::create([
                "name"=>$request->name,
                "country_id"=>$request->country_id,
                "region_id"=>$request->region_id,
                "status"=>"Active",
                "created_on"=>Carbon::now(),
            ]);
            DB::commit();
            return $this->genericResponse(true, "City created successfully", 201, $city);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getCities(){
        try {
            $cities = City::where("status", "Active")->get();
            return $this->genericResponse(true, "Cities", 200, $cities);

        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getCitiesById($cityId){
        try {
            $cities = City::where(["status"=>"Active", "id"=>$cityId])->get();
            return $this->genericResponse(true, "Cities", 200, $cities);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getCitiesByRegionId($regionId){
        try {
            $cities = City::where(["status"=>"Active", "region_id"=>$regionId])->get();
            return $this->genericResponse(true, "Cities", 200, $cities);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getCitiesByCountryId($countryId){
        try {
            $cities = City::where(["status"=>"Active", "country_id"=>$countryId])->get();
            return $this->genericResponse(true, "Cities", 200, $cities);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }
}
