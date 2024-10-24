<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VacancyComponents;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable=["uuid", "title", "description", "user_id", "sector_id", "category_id", "expires_on",
            "status", "location", "department", "employment_type", "job_type_id", "footer", "branch_id",
           "company_id", "start_on", "ends_on", "created_on", "created_by", "updated_on", "updated_by", "experience",
        "contract_type", "bid_security", "about_company", "summary", "classification"];

           public function components()
           {
               return $this->hasMany(VacancyComponents::class, 'vacancy_id');
           }
}
