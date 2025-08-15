<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MobileFeedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mobile_feedback';
    protected $fillable = [
        'username',
        'email',
        'subject',
        'message',
    ];
}
