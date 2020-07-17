<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    /**
     * Kolom-kolom yang dapat diisi
     */
    protected $fillable = [
        'company_id',
        'name',
        'code',
        'is_main_office',
        'phone',
        'address',
        'city',
        'region',
        'country',
        'note',
        'user_id',
        'user',
    ];

    /**
     * Mendapatkan pengguna-pengguna yang ada di cabang tersebut
     *
     * @return User
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
