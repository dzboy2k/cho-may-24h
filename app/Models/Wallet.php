<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "wallets";
    protected $fillable = ['user_id', 'payment_coin', 'sale_limit', 'depreciation_support_limit', 'get_depreciation_support'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
