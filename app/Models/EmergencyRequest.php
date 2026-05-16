<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name', 'age', 'blood_type', 'units',
        'urgency', 'hospital_name', 'city', 'ward',
        'contact_name', 'phone', 'notes', 'status',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];
}
