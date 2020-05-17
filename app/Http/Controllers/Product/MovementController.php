<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Alice\ApiResponser;
use App\Alice\BranchValidator;
use App\Alice\ExternalServices\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovementController extends Controller
{
    private $apiResponser;
    private $rules = []; // Rule diatur pada controller di dalam microservice yang bersangkutan
    private $product;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, BranchValidator $branchValidator, Product $product) {
        $this->apiResponser = $apiResponser;
        $this->branchValidator = $branchValidator;
        $this->product = $product;
    }

    /**
     * Menambahkan data movement kepada microservice product
     *
     * @param Request $request
     * @return Array
     */
    public function create(Request $request){
        if(!$this->branchValidator->isValidFromUser($request->branch_id, $request->auth)){
            return $this->apiResponser->error('Cabang tidak valid.', 400);
        }
        $movementData = $request->all();
        $movementData['user'] = $request->auth->name;

        $movement = $this->product->createMovement([
            'form_params' => $movementData
        ]);
    }
    /**
     * Membaca data movement dari microservice product
     *
     * @param Request $request
     * @return Array
     */
    public function read(Request $request){
        $movements = $this->product->readMovement([
            'query' => $request->all()
        ]);

        return $this->apiResponser->success($movements);
    }

    /**
     * Menghapus data movement
     *
     * @param Request $request
     * @return Array
     */
    public function delete(Request $request){
        $movement  = $this->product->deleteMovement([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($movement);
    }

    /**
     * Membaca data movement type
     * Untuk diisikan pada combobox atau autocomplete
     *
     * @return Array
     */
    public function readType(Request $request){
        $movementTypes = $this->product->readMovementType();

        return $this->apiResponser->success($movementTypes);
    }

    /**
     * Menambahkan data movement detail dari movement yang sudah ada
     *
     * @param Request $request
     * @return Array
     */
    public function createDetail(Request $request){
        $movementDetailData = $request->all();
        $movementDetailData['user'] = $request->auth->name;

        $movementDetail = $this->product->createMovementDetail([
            'form_params' => $movementDetailData
        ]);

        return $this->apiResponser->success($movementDetail);
    }
    /**
     * Membaca data movement detail dari movement_id yang diberikan
     *
     * @param Request $request
     * @return Array
     */
    public function readDetail(Request $request){
        $movementDetail = $this->product->readMovementDetail([
            'query' => $request->all()
        ]);

        return $this->apiResponser->success($movementDetail);
    }
    /**
     * Mengupdate data movement detail
     *
     * @param Request $request
     * @return Array
     */
    public function updateDetail(Request $request){
        $movementDetailData = $request->all();
        $movementDetailData['user'] = $request->auth->name;
        $movementDetail = $this->product->updateMovementDetail([
            'form_params' => $movementDetailData
        ]);

        return $this->apiResponser->success($movementDetail);
    }
    /**
     * Menghapus data movement detail berdasarkan data movement
     *
     * @param Request $request
     * @return Array
     */
    public function deleteDetail(Request $request){
        $movementDetail = $this->product->deleteMovementDetail([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($movementDetail);
    }

    /**
     * Membuat data serial berdasarkan data movement
     *
     * @param Request $request
     * @return Array
     */
    public function createSerial(Request $request){
        $serial = $this->product->createSerial([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($serial);
    }
    /**
     * Membaca data serial berdasarkan data movement
     *
     * @param Request $request
     * @return Array
     */
    public function readSerial(Request $request){
        $serials = $this->product->readSerial([
            'query' => $request->all()
        ]);

        return $this->apiResponser->success($serials);
    }
    /**
     * Mengupdate data serial
     *
     * @param Request $request
     * @return Array
     */
    public function updateSerial(Request $request){
        $serial = $this->product->updateSerial([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($serials);
    }
    /**
     * Menghapus data serial
     *
     * @param Request $request
     * @return Array
     */
    public function deleteSerial(Request $request){
        $serial = $this->product->deleteSerial([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($serial);
    }
}
