<?php

namespace App;

use App\Models\Scopes\UserScope;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'is_active',
        'remember_token',
        'id_number',
        'phone',
        'address',
        'city',
        'region',
        'country',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * User dengan ID 1 adalah "user keramat"
     * User tersebut hanya digunakan oleh developer
     * User tersebut dapat mengakses semua menu.
     *
     * @return void
     */
    protected static function boot(){
        parent::boot();

        static::addGlobalScope(new UserScope);
    }

    /**
     * Mendapatkan data roles
     *
     * @return Role
     */
    public function roles() {
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * Mendapatkan data perusahaan di mana saja user tersebut terdaftar
     *
     * @return Company
     */
    public function companies(){
        return $this->belongsToMany('App\Models\User');
    }
}
