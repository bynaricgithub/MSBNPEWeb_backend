<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    protected $table = 'master_categories';

    protected $fillable = [
        'master_category_type_id',
        'value',
        'label',
        'order_id',
        'status',
    ];

    public function type()
    {
        return $this->belongsTo(MasterCategoryType::class, 'master_category_type_id');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_category_id');
    }
}
