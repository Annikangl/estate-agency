<?php

namespace App\Models\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'ticket_messages';
    protected $fillable = ['user_id', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
