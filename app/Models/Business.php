<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{

    /**
     * Nama tabel di dalam database
     */
    protected $table = 'businesses';

    public $timestamps = false;

    /**
     * Kolom-kolom yang dapat diisi
     */
    protected $fillable = [
        'code',
        'name',
    ];

    /**
     * Mendapatkan daftar perusahaan
     *
     * @return Company
     */
    public function companies()
    {
        return $this->hasMany('App\Models\Company');
    }
}
