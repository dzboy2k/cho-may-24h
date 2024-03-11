<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostPlan extends Model
{
    use HasFactory;

    protected $table = 'posting_payment_plans';
    protected $fillable = ['image', 'title', 'summary', 'price_per_month', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_post_payments','id','package_id');
    }
}
