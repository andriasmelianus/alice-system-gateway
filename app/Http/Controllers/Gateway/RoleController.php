<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Alice\ApiResponser;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class RoleController extends Controller
{
    private $apiResponser;
    private $rules = [
        'name' => 'required|max:127',
        'slug' => 'max:127',
    ];
    private $role;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, Role $role)
    {
        $this->apiResponser = $apiResponser;
        $this->role = $role;
    }

    /**
     * Membuat role baru
     *
     * @param Request $request
     * @return Role
     */
    public function create(Request $request)
    {
        $role = Role::where('name', 'LIKE', $request->name)->first();

        if (!isset($role)) {
            $this->validate($request, $this->rules);
            $roleData = $request->all();
            if ($roleData['special'] == "") {
                $roleData['special'] = null;
            }
            $role = Role::create($roleData);
        }

        return $this->apiResponser->success($role, Response::HTTP_CREATED);
    }

    /**
     * Membaca data role
     *
     * @param Request $request
     * @return Role
     */
    public function read(Request $request)
    {
        $keyword = $request->input('keyword') . '%';
        $roles = Role::where('name', 'LIKE', $keyword)->get();

        return $this->apiResponser->success($roles);
    }

    /**
     * Membaca data role berdasarkan user yang dipilih
     *
     * @param Request $request
     * @return Role
     */
    public function readByUser(Request $request)
    {
        $roles = [];
        if ($request->column && $request->value) {
            $roles = DB::table('v_role_user')->where($request->column, $request->value)->get();
        }

        return $this->apiResponser->success($roles);
    }

    /**
     * Mengubah data role
     *
     * @param Request $request
     * @return Role
     */
    public function update(Request $request)
    {
        $this->validate($request, $this->rules);
        $roleData = $request->all();
        if ($roleData['special'] == "") {
            $roleData['special'] = null;
        }
        $role = Role::findOrFail($roleData['id']);
        $role->fill($roleData);

        if ($role->isClean()) {
            return $this->apiResponser->error('Tidak ada perubahan data.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $role->save();
        return $this->apiResponser->success($role);
    }

    /**
     * Menghapus data role
     *
     * @param Request $request
     * @return Role
     */
    public function delete(Request $request)
    {
        $role = Role::findOrFail($request->input('id'));
        $role->delete();

        return $this->apiResponser->success($role);
    }



    /**
     * Tambah permission pada role
     *
     * @param Request $request
     * @return Permission
     */
    public function addPermission(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $permissionsAdded = $role->permissions()->attach($request->permissionIds);

        return $this->apiResponser->success($permissionsAdded);
    }

    /**
     * Hapus permission dari role
     *
     * @param Request $request
     * @return JSON
     */
    public function removePermission(Request $request)
    {
        DB::table('permission_role')->whereIn('id', $request->ids)->delete();

        return $this->apiResponser->success('');
    }
}
