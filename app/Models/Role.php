<?php

namespace App\Models;

use App\Models\Scopes\RoleScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
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
     * Pemanfaatan scope role
     * Role dengan ID 1 adalah "role keramat"
     * Dapat mengakses seluruh menu
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RoleScope);
    }

    /**
     * Mendapatkan daftar User berdasarkan Role
     *
     * @return User
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Mendapatkan daftar Permission berdasarkan Role
     *
     * @return Permission
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission')->withTimestamps();
    }
}
