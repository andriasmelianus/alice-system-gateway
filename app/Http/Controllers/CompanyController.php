<?php

namespace App\Http\Controllers;

use App\Alice\ApiResponser;
use App\Models\Company;
use App\Models\Business;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class CompanyController extends Controller
{
    private $apiResponser;
    private $rules = [
        'name' => 'required|max:127|unique:companies',
        'tax_id' => 'max:127',
        'business' => 'max:127',
        'industry' => 'max:127',
        'website' => 'max:127',
    ];
    private $company;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, Company $company) {
        $this->apiResponser = $apiResponser;
        $this->company = $company;
    }

    /**
     * Membuat data perusahaan
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request){
        // $company = Company::where('name', 'LIKE', $request->name)->first();

        if(!isset($company)){
            $this->validate($request, $this->rules);

            $companyData = $request->all();
            if($companyData['business']<>''){
                $companyData['business_id'] = Business::where('name', $companyData['business'])->first()->id;
            }else{
                unset($companyData['business']);
            }
            if($companyData['industry']<>''){
                $companyData['industry_id'] = Industry::where('name', $companyData['industry'])->first()->id;
            }else{
                unset($companyData['industry']);
            }
            $company = Company::create($companyData);
        }

        return $this->apiResponser->success($company, Response::HTTP_CREATED);
    }

    /**
     * Membaca data perusahaan
     *
     * @param Request $request
     * @return JSON
     */
    public function read(Request $request){
        $keyword = $request->input('keyword').'%';
        $companies = Company::where('name', 'LIKE', $keyword)->get();

        return $this->apiResponser->success($companies);
    }

    /**
     * Membaca data perusahaan berdasarkan user login
     *
     * @param Request $request
     * @return JSON
     */
    public function readByMe(Request $request){
        $userId = $request->auth['id'];
        $companyIds = DB::table('company_user')->where('user_id', $userId)->get()->pluck('company_id');
        $companies = Company::whereIn('id', $companyIds)->get();

        return $this->apiResponser->success($companies);
    }

    /**
     * Membaca data jenis bisnis untuk proses input dan update data company
     *
     * @param
     * @return JSON
     */
    public function readBusinesses(){
        $businesses = Business::all();
        return $this->apiResponser->success($businesses);
    }
    /**
     * Membaca data jenis industri untuk proses input dan update data company
     *
     * @param
     * @return JSON
     */
    public function readIndustries(){
        $industries = Industry::all();
        return $this->apiResponser->success($industries);
    }

    /**
     * Mengupdate data perusahaan
     *
     * @param Request $request
     * @return json
     */
    public function update(Request $request){
        $this->rules['name'] = 'required|max:127|unique:companies,name,'.$request->input('id');
        $this->validate($request, $this->rules);

        $company = Company::findOrFail($request->input('id'));
        $companyData = $request->all();
        if($companyData['business']<>''){
            $companyData['business_id'] = Business::where('name', $companyData['business'])->first()->id;
        }else{
            unset($companyData['business']);
        }
        if($companyData['industry']<>''){
            $companyData['industry_id'] = Industry::where('name', $companyData['industry'])->first()->id;
        }else{
            unset($companyData['industry']);
        }
        $company->fill($companyData);

        if($company->isClean()){
            return $this->apiResponser->error('Tidak ada perubahan data.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $company->save();
        return $this->apiResponser->success($company);
    }

    /**
     * Menghapus data perushaaan
     *
     * @param Request $request
     * @return JSON
     */
    public function delete(Request $request){
        $company = Company::findOrFail($request->input('id'));
        $company->delete();

        return $this->apiResponser->success($company);
    }



    /**
     * Menambahkan pengguna yang dapat mengakses data pada perusahaan tersebut
     *
     * @param Request $request
     * @return void
     */
    public function addUser(Request $request){
        $companyId = $request->input('company_id');
        $userId = $request->input('user_id');
        $title = $request->input('title');

        /** TO BE CONTINUED... */
        $companyUser = Company::findOrFail($companyId);
        $companyUser->users()->attach($userId, ['title'=>$title]);
        $companyUserData = DB::table('v_company_user')
            ->where('company_id', $companyId)
            ->where('user_id', $userId)
            ->first();

        return $this->apiResponser->success(json_encode($companyUserData));
    }

    /**
     * Menghapus pengguna dari perusahaan
     *
     * @param Request $request
     * @return void
     */
    public function removeUser(Request $request){
        // $companyId = $request->input('company_id');
        // $userId = $request->input('user_id');

        // $companyUser = Company::findOrFail($companyId);
        // $companyUser->users()->detach($userId);

        $companyUserId = $request->input('company_user_id');
        $companyUser = DB::table('company_user')->where('id', $companyUserId);
        if($companyUser->first()->user_id == $request->auth->id){
            return $this->apiResponser->error('Tidak dapat menghapus data Anda sendiri.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $companyUserDeletedCount = $companyUser->delete();
        return $this->apiResponser->success($companyUserDeletedCount);
    }
}
