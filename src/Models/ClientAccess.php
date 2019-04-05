<?php

namespace Rockbuzz\LaraClient\Models;

use Illuminate\Database\Eloquent\Model;

class ClientAccess extends Model
{
    protected $table = 'client_access';
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'date'
    ];
}
