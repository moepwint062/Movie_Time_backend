<?php

namespace App\Models\Home;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'bus_time'
    ];

    public static function boot()
    {
        parent::boot();
    }
}
