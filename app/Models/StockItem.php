<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_name',
        'quantity',
        'price',
        'total',
        'date',
    ];

    // Ensure timestamps are enabled
    public $timestamps = true;

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'item_name', 'item_name');
    }
}

