<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'content',
        'status_id',
        'created_by',
        'page_limit',
        'is_published',
        'is_draft',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
