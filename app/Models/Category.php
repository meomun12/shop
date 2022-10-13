<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    public $timestamps = FALSE;
        protected $fillable = [
        'image',
        'name'
    ];



    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function SaveUpdate($id, $objU): int
    {
        return DB::table($this->table)
            ->where('id',$id)
            ->update($objU);
    }
}
