<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PdfContent extends Model
{
    protected $fillable = ['file_name', 'page_number', 'content'];
}
