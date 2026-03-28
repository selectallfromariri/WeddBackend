<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ← add this
use Illuminate\Database\Eloquent\Model;

class BankQr extends Model
{
    use HasFactory; // ← add this

    protected $table = 'bank_qrs';

    protected $fillable = [
        'wedding_id',
        'bank_name',
        'account_name',
        'account_number',
        'qr_image',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }
}