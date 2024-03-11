<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['author_id','title', 'slug', 'show_in_home_slide', 'is_service', 'show_in_header', 'body','image','meta_description','status'];
    protected $table = 'pages';
}
