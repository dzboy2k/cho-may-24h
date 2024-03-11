<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlanPayment extends Model
{
    use HasFactory;

    protected $table = 'user_plan_payments';
    protected $fillable = ['user_id', 'package_id', 'expire_date', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function plan()
    {
        return $this->hasOne(PostPlan::class, 'id', 'package_id');
    }
}
