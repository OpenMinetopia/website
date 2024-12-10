<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PloiSettings extends Model
{
    protected $fillable = [
        'api_token',
        'default_server_id',
        'repository_url',
        'repository_branch'
    ];

    protected $hidden = [
        'api_token'
    ];
} 