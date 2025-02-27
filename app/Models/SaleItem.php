<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'item_name',
        'quantity',
        'price',
        'date',
    ];

    // Ensure timestamps are enabled
    public $timestamps = true;

    public function stockItem()
    {
        return $this->belongsTo(StockItem::class, 'item_name', 'item_name');
    }
}
