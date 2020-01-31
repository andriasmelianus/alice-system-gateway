<?php

namespace App\Http\Controllers;

use App\Alice\ApiResponser;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class PermissionController extends Controller
{
    private $apiResponser;
    private $rules = [

    ];
    private $permission;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, Permission $permission) {
        $this->apiResponser = $apiResponser;
        $this->permission = $permission;
    }

    /**
     * Membuat permission
     *
     * @param Request $request
     * @return Permission
     */
    public function create(Request $request){

    }

    /**
     * Membaca seluruh data permission
     * Digunakan untuk proses memilih permission
     * yang akan dipasangkan pada role
     *
     * @param Request $request
     * @return Permission
     */
    public function read(Request $request){
        $keyword = $request->input('keyword').'%';
        $permissions = DB::table('v_permissions')->where('name', 'LIKE', $keyword)->get();

        return $this->apiResponser->success($permissions);
    }

    /**
     * Membaca data permission
     * berdasarkan role yang dipilih.
     *
     * @param Request $request
     * @return Permission
     */
    public function readByRole(Request $request){
        // $keyword = $request->input('keyword').'%';
        $roleId = $request->input('role_id');
        $permissions = DB::table('v_permission_role')->where('role_id', $roleId)->get();

        return $this->apiResponser->success($permissions);
    }
}
