<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Alice\ApiResponser;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class PermissionController extends Controller
{
    private $apiResponser;
    private $rules = [];
    private $permission;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, Permission $permission)
    {
        $this->apiResponser = $apiResponser;
        $this->permission = $permission;
    }

    /**
     * Membuat permission
     *
     * @param Request $request
     * @return Permission
     */
    public function create(Request $request)
    {
    }

    /**
     * Membaca seluruh data permission
     * Digunakan untuk proses memilih permission
     * yang akan dipasangkan pada role
     *
     * @param Request $request {column: String, value: String/Number}
     * @return Permission
     */
    public function read(Request $request)
    {
        $permissions = DB::table('v_permissions')->get();
        return $this->apiResponser->success($permissions);
    }

    /**
     * Membaca data permission
     * berdasarkan role yang dipilih.
     *
     * @param Request $request
     * @return Permission
     */
    public function readByRole(Request $request)
    {
        $permissions = [];
        if ($request->column && $request->value) {
            $permissions = DB::table('v_permission_role')->where($request->column, $request->value)->get();
        }

        return $this->apiResponser->success($permissions);
    }
}
