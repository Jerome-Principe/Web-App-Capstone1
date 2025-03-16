<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterRFID extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'username',
        'serial_number',
        'email',
    ];
}
