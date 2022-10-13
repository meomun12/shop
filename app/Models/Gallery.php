<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Gallery extends Model
{
    protected $table = "galleries";
    public $timestamps = FALSE;
    protected $fillable = [
        'gallery_img',
        'product_id',
        'created_at'
    ];

    public static function where(string $string, $product_id)
    {
    }
}
