<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ["name", "code", "currency", "status", "created_on", "created_by", "updated_on", "updated_by"];
}
