<?php

namespace App\Http\Controllers;

use App\Alice\ApiResponser;
use App\Alice\ExternalServices\Contact;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Models\Scopes\UserScope;
use DB;

class UserController extends Controller
{
    private $apiResponser;
    private $rules;
    private $user;
    private $contact;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, User $user, Contact $contact) {
        $this->apiResponser = $apiResponser;
        $this->rules  = [
            'name' => 'required|max:127',
            'username' => ['required', 'min:5', 'max:127', Rule::unique('users', 'username')->where(function($query){
                return $query->whereNull('deleted_at');
            })],
            'password' => 'sometimes|required|max:127',
            'is_active' => 'boolean',
            'remember_token' => 'max:127',
            'id_number' => ['max:127', Rule::unique('users', 'id_number')->where(function($query){
                return $query->whereNull('deleted_at');
            })],
            'phone' => 'max:127',
            'address' => 'max:127',
            'city' => 'max:127',
            'region' => 'max:127',
            'country' => 'max:127',
        ];
        $this->user = $user;
        $this->contact = $contact;
    }

    /**
     * Menambah pengguna
     *
     * @param Request $request
     * @return JSON
     */
    public function create(Request $request){
        $this->validate($request, $this->rules);
        $newUserData = $request->all();

        // Cek apakah yang membuat user adalah user system
        // Bila bukan maka company ID sama dengan user pembuat
        if($request->auth['id'] != 1){
            $newUserData['company_id'] = $request->auth['company_id'];
        }
        $newUserData['password'] = app('hash')->make($request->password);
        $newUserData['id_number'] = $request->id_number == '' ? null : $request->id_number;
        $this->contact->extractContact($newUserData);
        $user = User::create($newUserData);

        return $this->apiResponser->success($user, Response::HTTP_CREATED);
    }

    /**
     * Membaca data pengguna
     *
     * @param Request $request {column, value}
     * @return JSON
     */
    public function read(Request $request){
        $users = [];
        if($request->auth['id'] == 1){
            $users = DB::table('v_users')->whereIn('id', User::all('id'))->get();
            return $this->apiResponser->success($users);
        }

        if($request->column && $request->value){
            $users = DB::table('v_users')
                ->where($request->column, $request->value)
                ->whereIn('id', User::select('id')->company($request->auth['company_id'])->get())->get();
        } else {
            $users = DB::table('v_users')
                ->whereIn('id', User::select('id')->company($request->auth['company_id'])->get())->get();
        }

        return $this->apiResponser->success($users);
    }

    /**
     * Membaca data pengguna yang sedang login
     *
     * @param Request $request
     * @return JSON
     */
    public function readByMe(Request $request){
        return $this->apiResponser->success($request->auth);
    }

    /**
     * Membaca data pengguna berdasarkan username yang diberikan.
     * Function ini berguna untuk proses penambahan data pada tabel company_user.
     * Proses penambahan pada tabel tersebut yaitu dengan melakukan pencarian pengguna terlebih dahulu berdasarkan username.
     * Dari username yang dikirimkan, server akan mengembalikan data user tersebut.
     *
     * @param Request $request
     * @return JSON
     */
    public function readByUsername(Request $request){
        $username = $request->input('username');
        $users = User::where('username', $username)->get();

        if(count($users) == 0){
            return $this->apiResponser->error(['username' => 'Username tidak ditemukan'], Response::HTTP_NOT_FOUND);
        }

        return $this->apiResponser->success($users->first());
    }

    /**
     * Mengubah data pengguna
     *
     * @param Request $request
     * @return JSON
     */
    public function update(Request $request){
        // Unset rule username, karena username tidak dapat diganti
        unset($this->rules['username']);

        // Periksa apakah user mengganti password
        if($request->input('password') == ''){
            unset($this->rules['password']);
        }
        // Periksa apakah user mengganti id_number
        if($request->input('id_number') == ''){
            unset($this->rules['id_number']);
        }else{
            $this->rules['id_number'] = ['max:127', Rule::unique('users', 'id_number')->where(function($query) use($request){
                return $query->whereNull('deleted_at')->where('id', '<>', $request->input('id'));
            })];
        }
        $this->validate($request, $this->rules);

        // Pindah data pada $request ke variabel $userUpdatedData
        $userUpdatedData = $request->all();
        // Hapus rule username
        unset($userUpdatedData['username']);

        $user = User::findOrFail($userUpdatedData['id']);
        $user->fill($userUpdatedData);

        if($user->isClean()){
            return $this->apiResponser->error('Tidak ada perubahan data.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if(!$user->isClean('password')){
            $user->password = app('hash')->make($user->password);
        }
        $this->contact->extractContact($userUpdatedData);

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
        if($request->auth->id == $request->id){
            return $this->apiResponser->error('Tidak dapat menghapus data Anda sendiri.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

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
        $user = User::findOrFail($request->user_id);
        $user->roles()->attach($request->roleIds);

        return $this->apiResponser->success("");
    }

    /**
     * Menghapus data role berdasarkan user yang dipilih.
     *
     * @param Request $request
     * @return JSON
     */
    public function removeRole(Request $request){
        DB::table('role_user')->where('id', $request->id)->delete();

        return $this->apiResponser->success('');
    }
}
