<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin' // Add this field
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean' // Add this cast
    ];

    // Add this method to check if user is admin
    public function isAdmin()
    {
        return $this->is_admin;
    }
    // In Slider model
    public function getMediaUrlAttribute()
    {
        return $this->media_path ? Storage::disk('public')->url($this->media_path) : null;
    }


}