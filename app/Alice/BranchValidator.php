<?php
namespace App\Alice;

use App\Models\Company;
use App\Models\Branch;
use App\User;

class BranchValidator {
    private $company;
    private $branch;
    private $user;

    /**
     * Constructor untuk kelas branch validator
     */
    public function __construct(Company $company, Branch $branch, User $user){
        $this->company = $company;
        $this->branch = $branch;
        $this->user = $user;
    }

    /**
     * Periksa apakah branch tersebut benar-benar masih dalam 1 company
     * Hal ini untuk mencegah user nakal yang berusaha mengupdate data
     * branch dari perusahaan selain perusahaannya sendiri.
     *
     * @param Integer $branchId
     * @param Integer $companyId
     *
     * @return Boolean
     */
    public function isValidFromCompany($branchId, $companyId){
        $branchCount = $this->branch->where('company_id', $companyId)->where('branch_id', $branchId)->count();
        if($branchCount){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
     * Periksa apakah branch yang dimaksud masih satu perusahaan
     * dengan perusahaan di mana user tersebut terdaftar.
     *
     * @param Integer $branchId
     * @param Array $userData: User data yang didapatkan dari middleware jwt.auth
     *
     * @return Boolean
     */
    public function isValidFromUser($branchId, $userData){
        if($branchId == $userData->branch_id){
            return TRUE;
        }

        if($this->isValidFromCompany($branchId, $userData->company_id)){
            $userSpecials = Arr::pluck($request->auth->permission, 'special');
            $userSlugs = Arr::pluck($request->auth->permission, 'slug');

            if(in_array('nothing', $userSpecials)){
                return FALSE;
            }

            if(!in_array('everything', $userSpecials)){
                if(!in_array('manage-other-branch', $userSlugs)){
                    return FALSE;
                }
            }

            return TRUE;
        }
    }
}
