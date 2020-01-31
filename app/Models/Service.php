<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model {
    use SoftDeletes;

    protected $table = 'services';

    /**
     * Kolom-kolom yang dapat diisi
     */
    protected $fillable = [
        'name',
        'description',
        'base_url',
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
