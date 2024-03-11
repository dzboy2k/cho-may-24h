<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'price', 'receive_support', 'expire_limit_month', 'is_received', 'is_paid', 'created_at', 'user_id'];
    protected $table = 'orders';

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
