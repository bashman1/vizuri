<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationBackground extends Model
{
    use HasFactory;

    protected $fillable=["uuid", "school", "city_id", "country_id", "study_field", "grade",
    "user_id", "status", "created_on", "created_by", "updated_on", "updated_by"];

}
