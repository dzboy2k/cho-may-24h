<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IDCards extends Model
{
    use HasFactory;

    protected $table = 'id_cards';
    protected $fillable = [
        'user_id',
        'issue',
        'address',
        'identify_code'
    ];
}