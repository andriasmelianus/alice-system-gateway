<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Alice\ApiResponser;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Business;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use DB;

class CompanyController extends Controller
{
    private $apiResponser;
    private $rules;
    private $company;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, Company $company) {
        $this->apiResponser = $apiResponser;
        $this->rules  = [
            'name' => ['required','max:127',Rule::unique('companies')->where(function ($query){
                return $query->whereNull('deleted_at');
            })],
            'tax_id' => 'max:127',
            'business' => 'max:127',
            'industry' => 'max:127',
            'website' => 'max:127',
        ];
        $this->company = $company;
    }

    /**
     * Membuat data perusahaan
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request){
        $this->validate($request, $this->rules);

        $companyData = $request->all();
        $this->createBusiness($companyData['business']);
        $this->createIndustry($companyData['industry']);
        $company = Company::create($companyData);

        return $this->apiResponser->success($company, Response::HTTP_CREATED);
    }

    /**
     * Membaca data perusahaan
     *
     * @param Request $request
     * @return JSON
     */
    public function read(Request $request){
        $companies = [];

        // User ingin mendapatkan data berdasarkan ID
        if($request->id){
            $companies = Company::where('id', $request->id)->get();
            return $this->apiResponser->success($companies);
        }

        // !!!HARD CODED!!!
        if($request->auth['id'] == 1){
            $companies = Company::where('name', 'LIKE', '%'.$request->keyword.'%')->get();
        }else{
            $companies = Company::where('name', 'LIKE', '%'.$request->keyword.'%')->where('company_id', $request->auth['company_id'])->get();
        }

        return $this->apiResponser->success($companies);
    }



    /**
     * Mengupdate data perusahaan
     *
     * @param Request $request
     * @return json
     */
    public function update(Request $request){
        $this->rules['name'] = ['required','max:127',Rule::unique('companies')->where(function ($query) use($request) {
                return $query->whereNull('deleted_at')->where('id', '<>', $request->id);
            })];
        $this->validate($request, $this->rules);

        $company = Company::findOrFail($request->input('id'));
        $companyData = $request->all();
        $this->createBusiness($companyData['business']);
        $this->createIndustry($companyData['industry']);
        unset($companyData['business']);
        unset($companyData['industry']);
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
     * Membuat data jenis bisnis
     *
     * @param String $business
     * @return void
     */
    public function createBusiness($business){
        if($business != null){
            Business::firstOrCreate([
                'name' => $business
            ]);
        }
    }
    /**
     * Membaca data jenis bisnis untuk proses input dan update data company
     *
     * @param Request $request
     * @return JSON
     */
    public function readBusiness(Request $request){
        $businesses = Business::where('name', 'LIKE', '%'.$request->keyword.'%')->get();
        return $this->apiResponser->success($businesses);
    }

    /**
     * Membuat dat ajenis industri
     *
     * @param String $industry
     * @return void
     */
    public function createIndustry($industry){
        if($industry != null){
            Industry::firstOrCreate([
                'name' => $industry
            ]);
        }
    }
    /**
     * Membaca data jenis industri untuk proses input dan update data company
     *
     * @param Request $request
     * @return JSON
     */
    public function readIndustry(Request $request){
        $industries = Industry::where('name', 'LIKE', '%'.$request->keyword.'%')->get();
        return $this->apiResponser->success($industries);
    }

}
