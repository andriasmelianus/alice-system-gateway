<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model {
    use SoftDeletes;

    protected $table = 'roles';

    /**
     * Kolom-kolom yang dapat diisi
     */
    protected $fillable = [
        'name',
        'slug',
        'special',
    ];

    /**
     * Mendapatkan daftar User berdasarkan Role
     *
     * @return User
     */
    public function users() {
        return $this->belongsToMany('App\User');
    }

    /**
     * Mendapatkan daftar Permission berdasarkan Role
     *
     * @return Permission
     */
    public function permissions(){
        return $this->belongsToMany('App\Model\Permisison');
    }
}
