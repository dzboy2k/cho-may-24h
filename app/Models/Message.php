<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'sender_id', 'receiver_id', 'message', 'image_path', 'readed'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
