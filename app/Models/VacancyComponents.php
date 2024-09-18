<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacancyComponents extends Model
{
    use HasFactory;
    protected $fillable=["uuid", "vacancy_id", "ind", "description", "status", "created_on",
                        "created_by", "updated_on", "updated_by"];
}
