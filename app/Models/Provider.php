<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image_id'];
    protected $table = "providers";

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
