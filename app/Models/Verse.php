<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    protected $fillable = ['book_id', 'chapter', 'verse', 'text', 'version'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function commentaries()
    {
        return $this->hasMany(Commentary::class);
    }}
