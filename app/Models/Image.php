<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'org_name',
        'name'
    ];
    
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
