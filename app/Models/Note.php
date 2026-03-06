<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'reference_link',
    ];

    public function getReferenceLinkAttribute($value)
    {
        if (!$value) {
            return null;
        }

        if (!str_starts_with($value, 'http://') && !str_starts_with($value, 'https://')) {
            return 'https://' . $value;
        }

        return $value;
    }
}
