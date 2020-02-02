<?php

namespace App\Http\Controllers;

use App\Alice\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class UserController extends Controller
{
    private $apiResponser;
    private $rules = [
        'name' => 'required|max:127',
        'username' => 'required|max:127',
        'password' => 'sometimes|required|max:127',
        'is_active' => 'boolean',
        'remember_token' => 'max:127',
        'id_number' => 'max:127|unique:users',
        'phone' => 'max:127',
        'address' => 'max:127',
        'city' => 'max:127',
        'region' => 'max:127',
        'country' => 'max:127',
    ];
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, User $user) {
        $this->apiResponser = $apiResponser;
        $this->user = $user;
    }

    /**
     * Menambah pengguna
     *
     * @param Request $request
     * @return JSON
     */
    public function create(Request $request){
        $user = User::where('name', 'LIKE', $request->name)->first();

        if(!isset($user)){
            $this->validate($request, $this->rules);
            $newUserData = $request->all();
            $newUserData['password'] = app('hash')->make($request->password);
            $newUserData['id_number'] = $request->id_number == '' ? null : $request->id_number;
            $user = User::create($newUserData);
        }

        return $this->apiResponser->success($user, Response::HTTP_CREATED);
    }

    /**
     * Membaca data pengguna
     *
     * @param Request $request
     * @return JSON
     */
    public function read(Request $request){
        $keyword = $request->input('keyword').'%';
        $users = User::where('name', 'LIKE', $keyword)->get();

        return $this->apiResponser->success($users);
    }

    /**
     * Mengubah data pengguna
     *
     * @param Request $request
     * @return JSON
     */
    public function update(Request $request){
        if($request->input('password') == ''){
            unset($this->rules['password']);
        }
        if($request->input('id_number') == ''){
            unset($this->rules['id_number']);
        }else{
            $this->rules['id_number'] = 'max:127|unique:users,id_number,'.$request->input('id');
        }
        $this->validate($request, $this->rules);

        $user = User::findOrFail($request->input('id'));
        $user->fill($request->all());

        if($user->isClean()){
            return $this->apiResponser->error('Tidak ada perubahan data.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if(!$user->isClean('password')){
            $user->password = app('hash')->make($user->password);
        }

        $user->save();
        return $this->apiResponser->success($user);
    }

    /**
     * Menghapus data pengguna
     *
     * @param Request $request
     * @return JSON
     */
    public function delete(Request $request){
        $user = User::findOrFail($request->input('id'));
        $user->delete();

        return $this->apiResponser->success($user);
    }



    /**
     * Menambah data role berdasarkan user yang dipilih
     *
     * @param Request $request
     * @return JSON
     */
    public function addRole(Request $request){
        $user = User::findOrFail($request->input('user_id'));
        $rolesToAdd = collect($request->roles);
        $roleIds = $rolesToAdd->pluck('id');
        $user->roles()->attach($roleIds);

        $rolesAdded = DB::table('v_role_user')
            ->whereIn('role_id', $roleIds)
            ->where('user_id', $user->id)
            ->get();

        return $this->apiResponser->success($rolesAdded);
    }

    /**
     * Menghapus data role berdasarkan user yang dipilih.
     *
     * @param Request $request
     * @return JSON
     */
    public function removeRole(Request $request){
        $user = User::findOrFail($request->input('user_id'));
        // $permissionsToRemove = collect($request->input('roles'));
        $user->roles()->detach($request->input('roles'));

        return $this->apiResponser->success('');
    }
}
