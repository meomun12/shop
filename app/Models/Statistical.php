<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistical extends Model
{
    use HasFactory;
    protected $table = "statistical";
    public $timestamps = FALSE;
    protected $fillable = [
    'id',
    'order_date',
    'sales',
    'quantily',
    'total_order',
    ];

    public function con_order_date()
    {
        return $this->belongsTo(Order::class, 'order_date');
    }
}
