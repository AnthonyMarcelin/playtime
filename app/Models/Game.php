<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Game extends Model
{
    protected $fillable = [
        'steam_appid',
        'title',
        'cover_url',
        'platform',
        'genre',
        'source'
    ];

    public function gameSessions(): HasMany
    {
        return $this->hasMany(GameSession::class);
    }
}
