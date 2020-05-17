<?php
namespace App\Http\Controllers\Product;

use App\Alice\ApiResponser;
use App\Alice\ExternalServices\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller {
    private $apiResponser;
    private $product; // External services

    /**
     * Create controller instance
     */
    public function __construct(ApiResponser $apiResponser, Product $product){
        $this->apiResponser = $apiResponser;
        $this->product = $product;
    }

    /**
     * Membaca data brand
     * Untuk dipasangkan pada control autocomplete
     *
     * @param Request $request
     * @return Array
     */
    public function get(Request $request){
        $brands = $this->product->getBrand([
            'query' => $request->all()
        ]);

        return $this->apiResponser->success($brands);
    }
}
