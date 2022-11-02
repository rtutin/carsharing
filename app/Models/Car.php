<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the car.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
