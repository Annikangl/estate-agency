<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Network
 * @package App\Models\User
 * @property  int $user_id
 * @property string $network
 * @property string $identity
 */

class Network extends Model
{
    use HasFactory;

    protected $table = 'user_networks';

    protected $fillable = ['network', 'identity'];

    public $timestamps = false;
}
