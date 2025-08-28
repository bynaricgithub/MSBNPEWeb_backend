<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeMenu extends Model
{
    use HasFactory;

    protected $table = 'homemenu';

    protected $guarded = [];
}
