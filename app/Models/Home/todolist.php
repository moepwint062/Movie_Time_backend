<?php

namespace App\Models\Home;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    use HasFactory;
    protected $fillable = [
        'alarm',
        'time_to_teeth',
        'breakfast_time'
    ];

    public static function boot()
    {
        parent::boot();
    }
}
