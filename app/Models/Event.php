<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'id',
        'time',
        'robot_id',
        'x',
        'y',
        'status',
        'battery',
    ];

     protected $hidden = [
    ];

    protected function casts(): array
    {
        return [];
    }

    public function robot()
    {
        return $this->belongsTo(Robot::class);
    }
}
