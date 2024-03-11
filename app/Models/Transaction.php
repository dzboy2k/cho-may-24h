<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";
    public $incrementing = false;
    protected $fillable = ['id', 'type', 'fluctuation', 'created_at', 'status', 'wallet_id', 'description'];

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
