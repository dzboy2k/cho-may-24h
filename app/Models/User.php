<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Str;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'phone', 'gender', 'dob', 'introduce', 'api_auth_token', 'avatar', 'password', 'reset_code'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    protected $table = 'users';
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }

    public function fullAddresses($userId)
    {
        return UserAddress::where('user_id', $userId)
            ->join('address', 'address_id', '=', 'address.id')
            ->pluck('full_address');
    }

    public function addresses()
    {
        return $this->hasManyThrough(Address::class, UserAddress::class, 'user_id', 'id', 'id', 'address_id');
    }

    public function idCard()
    {
        return $this->hasOne(IDCards::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function plan()
    {
        return $this->hasOneThrough(PostPlan::class, UserPlanPayment::class, 'package_id', 'user_id');
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }
}
