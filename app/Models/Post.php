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
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getImagePathAttribute()
    {
        return 'posts/' . $this->images->first()->name;
    }
    public function getImageUrlAttribute()
    {
        if (config('filesystems.default') == 'gcs'){
            return Storage::temporaryUrl($this->image_path, now()->addMinutes(5));
        } 
        return Storage::url($this->image_path);
    }
}
