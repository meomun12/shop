<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Notifications\Notifiable;

class User extends \Eloquent implements Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use AuthenticableTrait;
    public $timestamps = false;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'password',
        'role_id',
        'email',
        'phone',
        'address',
        'status',
    ];

    protected  $primaryKey = 'id';
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function SaveUpdate($id, $data){
        return DB::table($this->table)
            ->where('id',$id)
            ->update($data);
    }
    public function SaveNew($data){
        return DB::table($this->table)->insertGetId($data);
    }
    public function getAuthPassword()
    {
        return $this->password;
    }
    public function resetpassword($id)
    {
        DB::table($this->table)
            ->where('id',$id);
    }
}
