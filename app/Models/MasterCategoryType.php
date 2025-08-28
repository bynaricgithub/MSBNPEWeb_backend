<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterCategoryType extends Model
{
    protected $table = 'master_category_types';

    protected $fillable = ['name', 'label'];

    public function categories()
    {
        return $this->hasMany(MasterCategory::class, 'master_category_type_id');
    }
}
