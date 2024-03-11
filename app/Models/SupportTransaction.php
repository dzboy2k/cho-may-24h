<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTransaction extends Model
{
    use HasFactory;

    protected $table = 'support_transactions';
    public $incrementing = false;
    protected $fillable = ['id', 'fluctuation', 'receive_type', 'description', 'expiration_date', 'created_at', 'wallet_id', 'is_need_for_calc_each_day'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    protected static function generateId()
    {
        do {
            $uuid = strtoupper('cm-' . str_pad(mt_rand(1, 999999999), config('constants.UUID_MAX_NUMBER_LENGTH'), '0', STR_PAD_LEFT));
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
