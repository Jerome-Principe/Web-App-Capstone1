<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Drink extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'item_name',
        'quantity',
        'price',
        'date',
        'time'
    ];

    // Ensure timestamps are enabled
    public $timestamps = true;
}
