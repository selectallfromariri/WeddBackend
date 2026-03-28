<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wedding extends Model
{
    use HasFactory;
    protected $fillable = [
        'wedding_code',
        'wedder_id',
        'bride_name',
        'groom_name',
        'date',
        'venue',
        'cover_photo',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'date'         => 'date',
            'is_published' => 'boolean',
        ];
    }

    // Auto-generate wedding_code on create
protected static function boot()
{
    parent::boot();
    static::creating(function ($wedding) {
        if (empty($wedding->wedding_code)) { // ← add this check
            $wedding->wedding_code = 'WED-' . strtoupper(Str::random(6));
        }
    });
}

    // Relationships
    public function wedder()
    {
        return $this->belongsTo(User::class, 'wedder_id');
    }

    public function tentatives()
    {
        return $this->hasMany(Tentative::class)->orderBy('time');
    }

    public function bankQr()
    {
        return $this->hasOne(BankQr::class);
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}