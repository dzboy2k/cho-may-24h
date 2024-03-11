<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';

    protected $fillable = [
        'province_id',
        'district_id',
        'ward_id',
        'street_address',
        'full_address',
    ];

    public function userAddress()
    {
        return $this->hasOne(UserAddress::class, 'address_id');
    }
}