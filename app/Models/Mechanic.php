<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    //
  protected $fillable = [
        'name',
        'phone',
        'is_active'
    ];
    // In app/Models/Mechanic.php
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
