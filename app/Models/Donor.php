<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'blood_type', 'city',
        'phone', 'is_available',
        'latitude', 'longitude',
        'last_donated_at', 'donations_count',
    ];

    protected $casts = [
        'is_available'   => 'boolean',
        'last_donated_at'=> 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
