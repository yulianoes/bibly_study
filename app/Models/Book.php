<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['name', 'abbrev', 'testament'];

    public function verses()
    {
        return $this->hasMany(Verse::class);
    }}
