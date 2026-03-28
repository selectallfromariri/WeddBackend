<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Rsvp extends Model
{
    use HasFactory;
    protected $fillable = [
        'wedding_id',
        'visitor_id',
        'attendance',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'attendance' => 'string',
        ];
    }

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