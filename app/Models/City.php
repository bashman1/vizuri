<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ["name", "country_id", "region_id", "status", "created_on", "created_by", "updated_on", "updated_by"];
}
