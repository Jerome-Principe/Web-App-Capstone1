<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use HasFactory, SoftDeletes;

    // Mass-assignable attributes based on your table structure
    protected $fillable = [
        'first_name',
        'last_name',
        'contact_number',
        'expertise',
        'session',
        'rates',
    ];

    // Define relationships if needed
    public function appointments()
    {
        return $this->hasMany(PendingAppointment::class);
    }
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
