<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $table = "order_details";
    public $timestamps = False;
        protected $fillable = [
        'order_id',
        'product_id',
        'total',
        'unit_price',
        'showid'
    ];
    protected  $primaryKey = 'showid';

    public function product_order()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function category_order()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}