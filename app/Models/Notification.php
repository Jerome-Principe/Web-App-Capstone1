<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'feature',
        'description',
        'date',
        'is_deleted'
    ];

    protected $casts = [
        'date' => 'date',
        'is_deleted' => 'boolean'
    ];

    /**
     * Scope to get only active (non-deleted) notifications
     */
    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    /**
     * Scope to get only deleted notifications
     */
    public function scopeDeleted($query)
    {
        return $query->where('is_deleted', true);
    }
}