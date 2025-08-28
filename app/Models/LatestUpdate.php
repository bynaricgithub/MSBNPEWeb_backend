<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatestUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'order_id',
    ];

    protected $table = 'latest_update';
}
