<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'agenda',
        'scheduled_at',
        'contact_person',
        'company_name',
        'contact_phone',
        'contact_email',
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
}
