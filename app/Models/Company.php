<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable=["uuid", "name", "description", "address", "p_o_box", "user_id", "sector_id", "status", "created_on", "created_by", "updated_on", "updated_by", "business_name",
    "nature_of_business", "company_size_id", "phone_number", "alt_phone_number", "email", "zip_code", "country_id", "city_id", "region_id", "website", "linkedin", "headquarter"];
}
