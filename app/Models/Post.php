<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Post extends Model
{
    use HasFactory, Translatable;

    protected $table = 'posts';

    protected $fillable = [
        'author_id',
        'price',
        'support_limit',
        'addition_info',
        'description',
        'title',
        'status_id',
        'category_id',
        'brand_id',
        'slug',
        'provider_id',
        'post_state',
        'amount_view',
        'expire_limit_month',
        'is_official',
        'release_date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_posts', 'post_id', 'tag_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'posts_images', 'post_id', 'image_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function savedPost()
    {
        return $this->hasMany(SavedPost::class);
    }
}
