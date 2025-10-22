<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'details',
        'features',
        'media_path',
        'media_type',
        'is_active',
        'order'
    ];

    protected $appends = ['media_url'];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean'
    ];

    public function getMediaUrlAttribute()
    {
        return $this->media_path ? Storage::disk('public')->url($this->media_path) : null;
    }

    public function getMediaTypeAttribute($value)
    {
        return strpos($value, 'image/') === 0 ? 'image' : 'video';
    }
    
}