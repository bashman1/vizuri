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


    public function getCompanyProfile($companyId)
    {
        try {

            // $sql = "SELECT C.id, C.uuid, C.name, C.description, C.address, C.p_o_box, C.sector_id, C.status,
            // C.created_on, C.created_at, C.updated_at, C.business_name, C.nature_of_business, C.company_size_id,
            // C.phone_number, C.alt_phone_number, C.email, C.zip_code, C.country_id, C.city_id, C.region_id,
            // S.name AS sector, z.min AS min_size, Z.max AS max_size, z.description AS size_description,
            // C.website, C.linkedin, C.headquarter, B.name AS country, R.name AS region, D.name AS city
            // FROM companies C
            // LEFT JOIN sectors S ON S.id = C.sector_id
            // LEFT JOIN company_sizes Z ON Z.id = C.company_size_id
            // LEFT JOIN countries B ON B.id = C.country_id
            // LEFT JOIN regions R ON R.id = C.region_id
            // LEFT JOIN cities D ON D.id = C.city_id WHERE C.id = $companyId ";

            // $companyData = DB::select($sql);
            $companyData = $this->getCompanyData($companyId);
            return $this->genericResponse(true, "Company profile", 200, $companyData);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }



    public function getCompanyData($companyId){
        try {
            $sql = "SELECT C.id, C.uuid, C.name, C.description, C.address, C.p_o_box, C.sector_id, C.status,
            C.created_on, C.created_at, C.updated_at, C.business_name, C.nature_of_business, C.company_size_id,
            C.phone_number, C.alt_phone_number, C.email, C.zip_code, C.country_id, C.city_id, C.region_id,
            S.name AS sector, z.min AS min_size, Z.max AS max_size, z.description AS size_description,
            C.website, C.linkedin, C.headquarter, B.name AS country, R.name AS region, D.name AS city
            FROM companies C
            LEFT JOIN sectors S ON S.id = C.sector_id
            LEFT JOIN company_sizes Z ON Z.id = C.company_size_id
            LEFT JOIN countries B ON B.id = C.country_id
            LEFT JOIN regions R ON R.id = C.region_id
            LEFT JOIN cities D ON D.id = C.city_id WHERE C.id = $companyId ";

            return DB::select($sql);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }


    public function getCompanyJobs($companyId)
    {
        try {
            // $sql = "SELECT V.id, V.uuid, V.title, V.description, V.user_id, V.sector_id, V.category_id, V.expires_on,
            // V.status, V.location, V.department, V.employment_type, V.experience, V.job_type_id,
            // V.footer, V.branch_id, V.company_id, V.start_on, V.ends_on, V.created_at,
            // C.name AS company_name, S.name AS sector_name
            // FROM vacancies V
            // INNER JOIN companies C ON C.id = V.company_id
            // INNER JOIN sectors S ON S.id = V.sector_id
            // WHERE V.company_id = :companyId";

            // $companyData = DB::select($sql, ['companyId' => $companyId]);
            $companyData = $this->companyJobs($companyId);
            return $this->genericResponse(true, "Company jobs", 200, $companyData);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }


    public function companyJobs($companyId){
        try {
            $sql = "SELECT V.id, V.uuid, V.title, V.description, V.user_id, V.sector_id, V.category_id, V.expires_on,
            V.status, V.location, V.department, V.employment_type, V.experience, V.job_type_id,
            V.footer, V.branch_id, V.company_id, V.start_on, V.ends_on, V.created_at,
            C.name AS company_name, S.name AS sector_name
            FROM vacancies V
            INNER JOIN companies C ON C.id = V.company_id
            INNER JOIN sectors S ON S.id = V.sector_id
            WHERE V.company_id = :companyId";

            return DB::select($sql, ['companyId' => $companyId]);
            // return $this->genericResponse(true, "Company jobs", 200, $companyData);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }


    public function getUserCompanyDetails(){
        try {
            $user = auth()->user();
            if(!isset($user->company_id)){
                return $this->genericResponse(false, "Company details not found", 404, []);
            }
            $companyData = $this->getCompanyData($user->company_id);
            return $this->genericResponse(true, "Company profile", 200, $companyData);

        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function getUserCompanyJobs(){
        try {
            $user = auth()->user();
            if(!isset($user->company_id)){
                return $this->genericResponse(false, "Company details not found", 404, []);
            }
            $companyData = $this->companyJobs($user->company_id);
            return $this->genericResponse(true, "Company jobs", 200, $companyData);


        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }


}
