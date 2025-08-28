<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditableValues extends Model
{
    use HasFactory;

    protected $table = 'editable_values';

    protected $guarded = [];

    protected $fillable = ['inst_id', 'course_code', 'dom', 'tot_fee_fra', 'tuition_fee_fra', 'devl_fee_fra'];
}
