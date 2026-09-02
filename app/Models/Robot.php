<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Robot extends Model
{
    use HasFactory;
    protected $keyType = 'int';
    public $incrementing = false;


    protected $fillable = [
        'id',
        'type',
    ];

     protected $hidden = [
    ];

    protected function casts(): array
    {
        return [];
    }
}
