<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentary extends Model
{
    protected $fillable = ['verse_id', 'content', 'source'];

    public function verse()
    {
        return $this->belongsTo(Verse::class);
    }}
