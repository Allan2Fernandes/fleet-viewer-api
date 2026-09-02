<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function events(): HasMany {
        return $this->hasMany(Event::class);
    }
}
