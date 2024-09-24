<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Models\VacancyComponents;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VacancyController extends Controller
{

    public function createVacancy(Request $request)
    {

        try {
            DB::beginTransaction();
            $vacancy = Vacancy::create([
                "uuid" => $this->generateUuid(),
                "title" => $request->title,
                "description" => $request->description,
                "user_id" =>  1,
                "sector_id" => $request->sector_id,
                "category_id" => $request->category_id,
                "expires_on" => $request->expires_on,
                "status" => $request->status,
                "location" => $request->location,
                "department" => $request->department,
                "employment_type" => $request->employment_type,
                "job_type_id" => $request->job_type_id,
                "footer" => $request->footer,
                "branch_id" => 1,
                "company_id" => 1,
                "experience" => $request->experience,
                "start_on" => $request->start_on,
                "ends_on" => $request->ends_on,
                "created_by" => 1,
                "created_on" => Carbon::now(),
            ]);

            // Adding Requirements
            foreach ($request->requirements as $key => $value) {
                $component = VacancyComponents::create([
                    "uuid" => $this->generateUuid(),
                    "vacancy_id" => $vacancy->id,
                    "ind" => "REQUIREMENT",
                    "status" => "Active",
                    "description" => $value['description'],
                    // "created_by"=>$request->created_by,
                    "created_on" => Carbon::now(),
                ]);
            }

            // Adding roles and responsibilities
            foreach ($request->roles_and_responsibilities as $key => $value) {
                $component = VacancyComponents::create([
                    "uuid" => $this->generateUuid(),
                    "vacancy_id" => $vacancy->id,
                    "ind" => "ROLES_AND_RESPONSIBLY",
                    "status" => "Active",
                    "description" => $value['description'],
                    // "created_by"=>$request->created_by,
                    "created_on" => Carbon::now(),
                ]);
            }

            // Adding Benefits
            foreach ($request->benefits as $key => $value) {
                $component = VacancyComponents::create([
                    "uuid" => $this->generateUuid(),
                    "vacancy_id" => $vacancy->id,
                    "ind" => "BENEFIT",
                    "status" => "Active",
                    "description" => $value['description'],
                    // "created_by"=>$request->created_by,
                    "created_on" => Carbon::now(),
                ]);
            }

            // Adding why should work with us
            foreach ($request->why_work_with_us as $key => $value) {
                $component = VacancyComponents::create([
                    "uuid" => $this->generateUuid(),
                    "vacancy_id" => $vacancy->id,
                    "ind" => "WHY_YOU_SHOULD_WORK_WITH_US",
                    "status" => "Active",
                    "description" => $value['description'],
                    // "created_by"=>$request->created_by,
                    "created_on" => Carbon::now(),
                ]);
            }
            DB::commit();
            return $this->genericResponse(true, "Job created  successfully", 201, $vacancy);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }


    public function getJobList()
    {
        try {
            // Eager load related components in one query
            $vacancies = Vacancy::where('status', 'Active')
                ->with([
                    'components' => function ($query) {
                        $query->where('status', 'Active');
                    }
                ])->get();

            // Group the components into categories
            $tempArray = [];
            foreach ($vacancies as $vacancy) {
                $requirements = $vacancy->components->where('ind', 'REQUIREMENT');
                $roles_and_responsibilities = $vacancy->components->where('ind', 'ROLES_AND_RESPONSIBLY');
                $benefits = $vacancy->components->where('ind', 'BENEFIT');
                $why_work_with_us = $vacancy->components->where('ind', 'WHY_YOU_SHOULD_WORK_WITH_US');

                // Set the related data on the vacancy object
                $vacancy->requirements = $requirements;
                $vacancy->roles_and_responsibilities = $roles_and_responsibilities;
                $vacancy->benefits = $benefits;
                $vacancy->why_work_with_us = $why_work_with_us;

                unset($vacancy->components);

                $tempArray[] = $vacancy;
            }

            return $this->genericResponse(true, "Vacancy list", 200, $tempArray);
        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }


    public function test(Request $request){

        return view("welcome", []);
    }


    // public function getJobList(){
    //     try {
    //         $vacancies = Vacancy::where(["status"=>"Active"])->get();
    //         $tempArray = Array();
    //         foreach ($vacancies as $key => $value) {
    //             $requirements = VacancyComponents::where(["vacancy_id"=>$value["id"], "ind"=>"REQUIREMENT", "status" => "Active"])->get();
    //             $roles_and_responsibilities = VacancyComponents::where(["vacancy_id"=>$value["id"], "ind"=>"ROLES_AND_RESPONSIBLY", "status" => "Active"])->get();
    //             $benefits = VacancyComponents::where(["vacancy_id"=>$value["id"], "ind"=>"BENEFIT", "status" => "Active"])->get();
    //             $why_work_with_us = VacancyComponents::where(["vacancy_id"=>$value["id"], "ind"=>"WHY_YOU_SHOULD_WORK_WITH_US", "status" => "Active"])->get();

    //             $value["requirements"] = $requirements ;
    //             $value["roles_and_responsibilities"] = $roles_and_responsibilities ;
    //             $value["benefits"] = $benefits ;
    //             $value["why_work_with_us"] = $why_work_with_us ;

    //             array_push($tempArray, $value);
    //         }
    //         return $this->genericResponse(true, "Company list", 200, $tempArray);
    //     } catch (\Throwable $th) {
    //         return $this->genericResponse(false, $th->getMessage(), 500, $th);
    //     }
    // }
}
