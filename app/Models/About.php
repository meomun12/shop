<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = "about";
    public $timestamps = FALSE;

    protected $fillable = [
        'title',
        'description',
        'image',
        'created_at',
    ];
}
