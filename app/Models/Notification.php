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
        'is_deleted',
        'is_read'
    ];

    protected $casts = [
        'date' => 'date',
        'is_deleted' => 'boolean',
        'is_read' => 'boolean'
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

    /**
     * Scope to get only unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope to get only read notifications
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}