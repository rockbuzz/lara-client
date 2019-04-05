<?php

namespace Rockbuzz\LaraClient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rockbuzz\LaraClient\Token;

class Client extends Model
{
    protected $guarded = [];

    protected $dates = ['start_access', 'end_access'];

    public function accesses(): HasMany
    {
        return $this->hasMany(ClientAccess::class);
    }

    public function canAccess(): bool
    {
        if (
            ! $this->active
            or now() < $this->start_access
            or ($this->end_access and now() > $this->end_access)
            or ($this->limit_access and $this->limit_access < $this->accesses()->count())
        ) {
            return false;
        }
        return true;
    }

    public function getTokenAttribute()
    {
        return hash_hmac('sha256', $this->public_key, $this->secret_key);
    }
}
