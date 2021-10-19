<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function image()
    {
        return $this->hasOne(Image::class);
    }

    public function getImagePathAttribute()
    {
        return 'posts/' . $this->image->name;
    }
    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }
}
