<?php
namespace App\Http\Controllers\Product;

use App\Alice\ApiResponser;
use App\Alice\ExternalServices\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller {
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
     * Menambah data category
     *
     * @param Request $request
     * @return Array
     */
    public function add(Request $request){
        $category = $this->product->addCategory([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($category);
    }

    /**
     * Membaca data category
     * Untuk dipasangkan pada control autocomplete
     *
     * @param Request $request
     * @return Array
     */
    public function get(Request $request){
        $categories = $this->product->getCategory([
            'query' => $request->all()
        ]);

        return $this->apiResponser->success($categories);
    }

    /**
     * Menghapus/unlink data category dari sebuah produk
     *
     * @param Request $request
     * @return Boolean
     */
    public function remove(Request $request){
        $category = $this->product->removeCategory([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($category);
    }
}
