<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $table = 'sites';

    protected $connection = 'users';

    protected $fillable = [
        'db_host',
        'db_port',
        'db_database',
        'db_username',
        'db_password',
        'site_name',
    ];
}
