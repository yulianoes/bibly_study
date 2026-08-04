<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryLog extends Model
{
    protected $fillable = [
        'query',
        'theme',
        'intent',
        'ai_provider',
        'success',
        'duration_ms',
    ];

    protected $casts = [
        'success' => 'boolean',
    ];
}
