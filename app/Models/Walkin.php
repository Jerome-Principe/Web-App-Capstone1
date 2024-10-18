<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walkin extends Model
{
    use HasFactory;
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

}
