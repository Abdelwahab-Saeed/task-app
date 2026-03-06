<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'priority',
        'notes',
        'attachment',
        'reminder_date',
        'project_id',
        'user_id',
        'is_added',
    ];

    protected $casts = [
        'due_date' => 'date',
        'reminder_date' => 'date',
        'is_added' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
