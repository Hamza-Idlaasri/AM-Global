<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    use HasFactory;

    protected $table = 'notifs';

    protected $connection = 'users';

    protected $fillable = [
        'user_id',
        'hosts',
        'boxs',
        'services',
        'equips',
    ];
}
