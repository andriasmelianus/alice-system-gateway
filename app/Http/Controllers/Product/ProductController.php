<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Alice\ApiResponser;
use App\Alice\ImageMaker;
use App\Alice\ExternalServices\Product;
use App\Alice\GuidGeneratorTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use GuidGeneratorTrait;

    private $apiResponser;
    private $rules = []; // Rule diatur pada controller di dalam microservice yang bersangkutan
    private $product;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, Product $product) {
        $this->apiResponser = $apiResponser;
        $this->product = $product;
    }

    /**
     * Membuat data produk
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request){
        $productData = $request->all();
        $productData['company_id'] = $request->auth->company_id || $productData['company_id'];
        $productData['user'] = $request->auth->name;
        $product = $this->product->create([
            'form_params' => $productData
        ]);

        return $this->apiResponser->success($product, Response::HTTP_CREATED);
    }

    /**
     * Membaca data produk
     *
     * @param Request $request
     * @return JSON
     */
    public function read(Request $request){
        $products = $this->product->read([
            'query' => $request->all()
        ]);

        return $this->apiResponser->success($products);
    }

    /**
     * Mengupdate data produk
     *
     * @param Request $request
     * @return json
     */
    public function update(Request $request){
        $productData = $request->all();
        $productData['user'] = $request->auth->name;
        $product = $this->product->update([
            'form_params' => $productData
        ]);
        return $this->apiResponser->success($product);
    }

    /**
     * Menghapus data produk
     *
     * @param Request $request
     * @return JSON
     */
    public function delete(Request $request){
        $productData = $request->all();
        $productData['user'] = $request->auth->name;
        $product = $this->product->delete([
            'form_params' => $productData
        ]);
        return $this->apiResponser->success($product);
    }

    /**
     * Proses mengirimkan upload gambar kepada microservice Product
     *
     * @param Request $request
     * @return JSON
     */
    public function addImage(Request $request){
        $uploadedImage = $request->file('image');
        if(!$uploadedImage->isValid()){
            return $this->apiResponser->error('Upload gambar gagal.', 400);
        }

        // Siapkan nama untuk gambar yang baru diupload
        $newImageFilename = $request->product_id.'_'.$this->newGuid().'.'.$uploadedImage->extension();
        $uploadedImage->move('images/product/original/', $newImageFilename);

        // Handle gambar
        $imageMaker = new ImageMaker(base_path('public/images/product/original/'.$newImageFilename), $newImageFilename, 'product/');
        $imageMaker->makeAll();

        // Upload gambar ke microservice Product
        $image = $this->product->addImage([
            'multipart' => [
                [
                    'name' => 'product_id',
                    'contents' => $request->product_id
                ],[
                    'name' => 'user',
                    'contents' => $request->auth->name
                ],[
                    'name' => 'icon',
                    'contents' => \fopen($imageMaker->getBasePath().'icon/'.$newImageFilename, 'r')
                ],[
                    'name' => 'small',
                    'contents' => \fopen($imageMaker->getBasePath().'small/'.$newImageFilename, 'r')
                ],[
                    'name' => 'medium',
                    'contents' => \fopen($imageMaker->getBasePath().'medium/'.$newImageFilename, 'r')
                ],[
                    'name' => 'large',
                    'contents' => \fopen($imageMaker->getBasePath().'large/'.$newImageFilename, 'r')
                ],[
                    'name' => 'original',
                    'contents' => \fopen($imageMaker->getBasePath().'original/'.$newImageFilename, 'r')
                ]
            ]
        ]);

        return $this->apiResponser->success($image);
    }

    /**
     * Mendapatkan file gambar.
     *
     * @param Request $request
     * @return String ImagePath
     */
    public function getImage(Request $request){
    }

    /**
     * Menentukan gambar default pada sebuah produk
     *
     * @param Request $request
     * @return String
     */
    public function setDefaultImage(Request $request){
        $defaultImage = $this->product->setDefaultImage([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($defaultImage);
    }

    /**
     * Menghapus data gambar pada database.
     * File gambar masih tetap ada pada server.
     *
     * @param Request $request
     * @return void
     */
    public function removeImage(Request $request){
        $image = $this->product->removeImage([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($image);
    }
}
