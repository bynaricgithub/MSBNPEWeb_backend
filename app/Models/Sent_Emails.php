<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sent_Emails extends Model
{
    use HasFactory;

    protected $table = 'sent_emails';

    protected $guarded = [];
}
