<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function wedding()
    {
        return $this->hasOne(Wedding::class, 'wedder_id');
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class, 'visitor_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'visitor_id');
    }

    // Helpers
    public function isWedder(): bool
    {
        return $this->role === 'wedder';
    }

    public function isVisitor(): bool
    {
        return $this->role === 'visitor';
    }
}