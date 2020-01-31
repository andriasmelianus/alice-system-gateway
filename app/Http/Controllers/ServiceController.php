<?php

namespace App\Http\Controllers;

use App\Alice\ApiResponser;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    private $apiResponser;
    private $rules = [
        'name' => 'required|max:127',
        'base_url' => 'max:127',
        'secret' => 'max:127',
    ];
    private $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, Service $service) {
        $this->apiResponser = $apiResponser;
        $this->service = $service;
    }

    /**
     * Menambah data service
     *
     * @param Request $request
     * @return JSON
     */
    public function create(Request $request){
        $service = Service::where('name', 'LIKE', $request->name)->first();

        if(!isset($service)){
            $this->validate($request, $this->rules);
            $service = Service::create($request->all());
        }

        return $this->apiResponser->success($service, Response::HTTP_CREATED);
    }

    /**
     * Membaca data service
     *
     * @param Request $request
     * @return JSON
     */
    public function read(Request $request){
        $keyword = $request->input('keyword').'%';
        $services = Service::where('name', 'LIKE', $keyword)->limit(10)->get();

        return $this->apiResponser->success($services);
    }

    /**
     * Mengubah data service
     *
     * @param Request $request
     * @return JSON
     */
    public function update(Request $request){
        $this->validate($request, $this->rules);

        $service = Service::findOrFail($request->input('id'));
        $service->fill($request->all());

        if($service->isClean()){
            return $this->apiResponser->error('Tidak ada perubahan data.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $service->save();
        return $this->apiResponser->success($service);
    }

    /**
     * Menghapus data service
     *
     * @param Request $request
     * @return JSON
     */
    public function delete(Request $request){
        $service = Service::findOrFail($request->input('id'));
        $service->delete();

        return $this->apiResponser->success($service);
    }
}
