<?php

namespace App\Http\Controllers;

use App\Alice\ApiResponser;
use App\Alice\ExternalServices\Contact;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BranchController extends Controller
{
    private $apiResponser;
    private $rules = [
        'name' => 'required|max:127',
        'code' => 'max:127',
        // 'is_main_office' => 'boolean',
        'phone' => 'max:127',
        'address' => 'max:127',
        'city' => 'max:127',
        'region' => 'max:127',
        'country' => 'max:127',
    ];
    private $branch;
    private $contact;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, Branch $branch, Contact $contact) {
        $this->apiResponser = $apiResponser;
        $this->branch = $branch;
        $this->contact = $contact;
    }

    /**
     * Membuat data cabang
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request){
        $this->validate($request, $this->rules);
        $branchData = $request->all();
        $branchData['user_id'] = $request->auth->id;
        $branchData['user'] = $request->auth->name;
        $this->contact->extractContact($branchData);
        $branch = Branch::create($branchData);

        return $this->apiResponser->success($branch, Response::HTTP_CREATED);
    }

    /**
     * Membaca data cabang
     *
     * @param Request $request
     * @return JSON
     */
    public function read(Request $request){
        $branches = [];
        if($request->column && $request->value){
            $branches = Branch::where($request->column, $request->value)->get();
        }else if($request->keyword){
            $branches = Branch::where('name', 'LIKE', '%'.$request->keyword.'%')->get();
        }else{
            $branches = Branch::where('company_id', $request->auth['company_id'])->get();
        }

        return $this->apiResponser->success($branches);
    }

    /**
     * Membaca data cabang berdasarkan perushaan yang dipilih.
     *
     * @param Request $request
     * @return JSON
     */
    public function readByCompany(Request $request){
        $companyId = $request->input('company_id');
        $branches = Branch::where('company_id', $companyId)->get();

        return $this->apiResponser->success($branches);
    }

    /**
     * Mengupdate data cabang
     *
     * @param Request $request
     * @return json
     */
    public function update(Request $request){
        $this->validate($request, $this->rules);

        $branch = Branch::findOrFail($request->input('id'));
        $branchData = $request->all();
        $branchData['user_id'] = $request->auth->id;
        $branchData['user'] = $request->auth->name;
        $this->contact->extractContact($branchData);
        $branch->fill($branchData);

        if($branch->isClean()){
            return $this->apiResponser->error('Tidak ada perubahan data.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $branch->save();
        return $this->apiResponser->success($branch);
    }

    /**
     * Menghapus data cabang
     *
     * @param Request $request
     * @return JSON
     */
    public function delete(Request $request){
        $branch = Branch::findOrFail($request->input('id'));
        $branch->delete();

        return $this->apiResponser->success($branch);
    }
}
