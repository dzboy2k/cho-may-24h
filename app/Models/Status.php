<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];
    protected $table = "statuses";

    public function posts()
    {
        return $this->hasMany(Post::class, 'id', 'status_id');
    }
}
