<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;
    protected $table = 'machines';

    protected $fillable = ['item_name', 'quantity', 'date', 'time'];

    public function machineDefects()
    {
        return $this->hasMany(MachineDefect::class);
    }

}
