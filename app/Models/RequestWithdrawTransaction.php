<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestWithdrawTransaction extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'request_withdraw_transactions';
    protected $fillable = ['fluctuation', 'user_id', 'base_transaction_id', 'bank_name', 'bank_account', 'bank_owner', 'bank_branch', 'status', 'description'];

    protected static function generateId()
    {
        do {
            $uuid = strtoupper(\Str::random(20));
        } while (self::where('id', $uuid)->exists());

        return $uuid;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = static::generateId();
        });
    }
}