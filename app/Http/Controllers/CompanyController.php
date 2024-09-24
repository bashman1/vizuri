<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanySize;
use App\Models\Sector;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

    public function createCompany(Request $request)
    {
        try {
            DB::beginTransaction();
            $company = Company::create([
                "uuid" => $this->generateUuid(),
                "name" => $request->name,
                "description" => $request->description,
                "address" => $request->address,
                "p_o_box" => $request->p_o_box,
                "user_id" => 1,
                "sector_id" => $request->sector_id,
                "status" => "Active",
                "created_on" => Carbon::now(),
                "created_by" => 1,
            ]);
            DB::commit();
            return $this->genericResponse(true, "Company created successfully", 201, $company);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }


    public function createSector(Request $request)
    {
        try {
            DB::beginTransaction();
            $sector = Sector::create([
                "uuid" => $this->generateUuid(),
                "name" => $request->name,
                "description" => $request->description,
                "user_id" => 1,
                "status" => "Active",
                "created_on" => Carbon::now(),
                "created_by" => 1,
            ]);
            DB::commit();
            return $this->genericResponse(true, "Sector created successfully", 201, $sector);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }


    /**
     * Summary of getSectors
     * @return void
     */
    public function getSectors()
    {
        try {
            $sectors = Sector::where("status", "Active")->get();
            return $this->genericResponse(true, "Sectors fetched successfully", 201, $sectors);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }


    public function getCompaniesList()
    {
        try {
            $companies = DB::select("SELECT C.id, C.uuid, C.name, C.description, C.address, C.p_o_box, C.user_id,
                C.sector_id, C.status, C.created_at, C.updated_at, U.name AS user_name
                FROM companies C INNER JOIN sectors S ON S.id = C.sector_id
                INNER JOIN users U ON U.id = C.user_id");
            return $this->genericResponse(true, "Companies fetched successfully", 201, $companies);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getCompanyDetails($companyUuid)
    {
        try {
            $companies = DB::select("SELECT C.id, C.uuid, C.name, C.description, C.address, C.p_o_box, C.user_id,
                 C.sector_id, C.status, C.created_at, C.updated_at, U.name AS user_name
                 FROM companies C INNER JOIN sectors S ON S.id = C.sector_id
                 INNER JOIN users U ON U.id = C.user_id WHERE C.uuid =  '$companyUuid'");
            return $this->genericResponse(true, "Companies fetched successfully", 201, $companies);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function createCompanySize(Request $request)
    {
        try {
            DB::beginTransaction();
            $companySize = CompanySize::create([
                "description" => $request->description,
                "min" => $request->min,
                "max" => $request->max,
                "status" => "Active",
                "created_on" => Carbon::now(),
                "created_by" => 1,
            ]);

            DB::commit();
            return $this->genericResponse(true, "Company size created successfully", 201, $companySize);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getCompanySize()
    {
        try {
            $companySizes = CompanySize::where("status", "Active")->get();
            return $this->genericResponse(true, "Company size created successfully", 200, $companySizes);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function updateCompanyProfile(Request $request)
    {
        try {
            DB::beginTransaction();
            $company = Company::find($request->id);

            if (!isset($company)) {
                return $this->genericResponse(false, "Company not found", 404, $company);
            }
            $company->update([
                "business_name" => $request->business_name,
                "nature_of_business" => $request->nature_of_business,
                "company_size_id" => $request->company_size_id,
                "phone_number" => $request->phone_number,
                "alt_phone_number" => $request->alt_phone_number,
                "email" => $request->email,
                "zip_code" => $request->zip_code,
                "country_id" => $request->country_id,
                "city_id" => $request->city_id,
                "region_id" => $request->region_id,
                "website" => $request->website,
                "linkedin" => $request->linkedin,
                "headquarter" => $request->headquarter,
            ]);
            DB::commit();
            return $this->genericResponse(true, "Company profile updated successfully", 201, $company);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }
}
