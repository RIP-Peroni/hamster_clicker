<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Click extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'clicked_at'];

    protected $casts = [
        'clicked_at' => 'datetime'
    ];

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
