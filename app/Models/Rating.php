<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = "ratings";
    protected $primaryKey = "id";
    public $timestamps = FALSE;

    protected $fillable = [
        'ra_product_id',
        'ra_content',
        'ra_user_id',
        'ra_number',
        'created_at',
    ];

    public function product_comment(){
        return $this->belongsTo(Product::class, 'ra_product_id');
    }
    
    public function user_comment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'ra_user_id');
    }
}
