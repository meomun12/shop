<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = "vouchers";
    public $timestamps = FALSE;
    protected  $primaryKey = 'id';

    protected $fillable = [
        'name',
        'start_date',
        'finish_date',
        'code',
        'created_by',
        'created_at',
        'amount',
        'type',
        'value',
        'status',
    ];

}
