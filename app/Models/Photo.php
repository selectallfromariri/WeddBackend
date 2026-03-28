<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = [
        'wedding_id',
        'visitor_id',
        'image_url',
    ];

    // Relationships
    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    public function visitor()
    {
        return $this->belongsTo(User::class, 'visitor_id');
    }
}