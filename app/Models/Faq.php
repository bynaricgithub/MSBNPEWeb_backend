<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faqs';

    protected $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'order_id',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(MasterCategory::class, 'faq_category_id');
    }
}
