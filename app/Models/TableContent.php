<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableContent extends Model
{
    use HasFactory;

    protected $table = 'table_content'; // make sure your table name is correct

    protected $fillable = [
        'title',
        'date',
        // 'last_date',
        'type',
        'note',
        'dept',
        'inst',
        'imageUrl',
        'description',
        'downloads',
        'link',
        'order_id',
        'status',
    ];

    protected $casts = [
        'downloads' => 'array',
        'date' => 'date',
        // 'last_date' => 'date',
    ];
}
