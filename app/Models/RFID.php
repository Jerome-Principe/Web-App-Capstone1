<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFID extends Model
{
    use HasFactory;

    protected $table = 'rfids';
    protected $fillable = ['username', 'rfid', 'time_in', 'date_logged'];
}
