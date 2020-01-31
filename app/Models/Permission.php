<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model {
    use SoftDeletes;

    protected $table = 'permissions';

    /**
     * Kolom-kolom yang dapat diisi
     */
    protected $fillable = [
        'service_id',
        'name',
        'slug',
    ];

    /**
     * Mendapatkan data role
     *
     * @return Role
     */
    public function roles(){
        return $this->belongsToMany('App\Models\Role')->withTimestamps();
    }
}
