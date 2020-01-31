<?php

namespace App\Http\Controllers;
use App\Alice\ApiResponser;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
    public function __construct(ApiResponser $apiResponser, Role $role) {
        $this->apiResponser = $apiResponser;
        $this->role = $role;
    }

    /**
     * Membuat role baru
     *
     * @param Request $request
     * @return Role
     */
    public function create(Request $request){
        $role = Role::where('name', 'LIKE', $request->name)->first();

        if(!isset($role)){
            $this->validate($request, $this->rules);
            $role = Role::create($request->all());
        }

        return $this->apiResponser->success($role, Response::HTTP_CREATED);
    }

    /**
     * Membaca data role
     *
     * @param Request $request
     * @return Role
     */
    public function read(Request $request){
        $keyword = $request->input('keyword').'%';
        $roles = Role::where('name', 'LIKE', $keyword)->get();

        return $this->apiResponser->success($roles);
    }

    /**
     * Mengubah data role
     *
     * @param Request $request
     * @return Role
     */
    public function update(Request $request){
        $this->validate($request, $this->rules);

        $role = Role::findOrFail($request->input('id'));
        $role->fill($request->all());

        if($role->isClean()){
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
    public function delete(Request $request){
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
    public function addPermission(Request $request){
        $role = Role::findOrFail($request->role_id);
        $permissionsToAdd = collect($request->permissions);
        $role->permissions()->attach($permissionsToAdd->pluck('id'));

        return $this->apiResponser->success($permissionsToAdd);
    }

    /**
     * Hapus permission dari role
     *
     * @param Request $request
     * @return Permission
     */
    public function removePermission(Request $request){
        $role = Role::findOrFail($request->input('role_id'));
        // $permissionsToRemove = collect($request->input('permissions'));
        $role->permissions()->detach($request->input('permissions'));

        return $this->apiResponser->success('');
    }
}
