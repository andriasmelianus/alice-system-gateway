<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
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
