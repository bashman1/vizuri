<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable=["uuid", "name", "description", "user_id", "status", "created_on", "created_by", "updated_on", "updated_by"];
}
