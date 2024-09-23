<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySize extends Model
{
    use HasFactory;
    protected $fillable = ["description", "min", "max", "status", "created_on", "created_by", "updated_on", "updated_by"];
}
