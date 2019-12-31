<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

    /**
     * Nama tabel dalam database
     */
    protected $table = 'companies';

    /**
     * Kolom-kolom yang dapat diisi
     */
    protected $fillable = [
        'name',
        'description',
        'tax_id',
        'business_id',
        'business',
        'industry_id',
        'industry',
        'website',
        'note',
    ];

    /**
     * Mendapatkan data cabang
     *
     * @return Branch
     */
    public function branches(){
        return $this->hasMany('App\Models\Branch');
    }

    /**
     * Mendapatkan data pengguna
     *
     * @return User
     */
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
