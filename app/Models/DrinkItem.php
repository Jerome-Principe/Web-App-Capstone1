<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrinkItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'quantity',
        'price',
        'total',
        'date',
        'time',
    ];

    public function drinks()
    {
        return $this->hasMany(Drink::class, 'item_name', 'item_name');
    }
}

