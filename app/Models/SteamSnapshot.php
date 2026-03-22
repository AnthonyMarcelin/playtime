<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SteamSnapshot extends Model
{
    protected $fillable = [
    'user_id',
    'steam_appid',
    'total_minutes',
    'snapped_at',
];

protected $casts = [
    'snapped_at' => 'datetime',
];

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
}
