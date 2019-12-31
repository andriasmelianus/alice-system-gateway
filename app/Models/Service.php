<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {

    protected $table = 'services';

    /**
     * Kolom-kolom yang dapat diisi
     */
    protected $fillable = [
        'name',
        'description',
        'base_url',
    ];

    /**
     *
     */
    protected $hidden = [
        'secret'
    ];

    /**
     * Mendapatkan data permission
     *
     * @return Permission
     */
    public function permissions(){
        return $this->hasMany('App\Models\Permission');
    }
}
