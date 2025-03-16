<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileFeedback extends Model
{
    use HasFactory;

    protected $table = 'mobile_feedback';
    protected $fillable = [
        'username',
        'email',
        'subject',
        'message',
    ];
}
