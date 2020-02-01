<?php

namespace App\Http\Controllers;

use App\Alice\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private $apiResponser;
    private $rules = [
        'name' => 'required|max:127',
        'username' => 'required|max:127',
        'password' => 'required',
        'is_active' => 'boolean',
        'remember_token' => 'max:127',
        'id_number' => 'max:127',
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
            $user = User::create($request->all());
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
        $this->validate($request, $this->rules);

        $user = User::findOrFail($request->input('id'));
        $user->fill($request->all());

        if($user->isClean()){
            return $this->apiResponser->error('Tidak ada perubahan data.', Response::HTTP_UNPROCESSABLE_ENTITY);
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
}
