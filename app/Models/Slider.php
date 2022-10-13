<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = "slider";
    public $timestamps = FALSE;
        protected $fillable = [
        'title',
        'description',
        'image'
    ];
    public function SaveUpdate($id, $objU){
        return DB::table($this->table)
            ->where('id',$id)
            ->update($objU);
    }

}
