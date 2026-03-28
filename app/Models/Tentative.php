<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Tentative extends Model
{
    use HasFactory;
    protected $fillable = [
        'wedding_id',
        'time',
        'title',
        'note',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    // Relationships
    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }
}