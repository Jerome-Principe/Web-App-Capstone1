<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Walkin extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'date',
        'time',
        'gender',
        'age',
        'city',
        'province',
        'zipcode',
        'amount',
        'payment',
    ];

    // Ensure timestamps are enabled
    public $timestamps = true;

}
