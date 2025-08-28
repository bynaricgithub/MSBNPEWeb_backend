<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Tracker extends Model
{
    use HasFactory;

    protected $table = 'user_tracker';

    protected $guarded = [];
}
