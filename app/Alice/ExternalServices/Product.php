<?php
namespace App\Alice\ExternalServices;

use App\Alice\ExternalServiceCommunicator;

class Product extends ExternalServiceCommunicator {

    /**
     * Constructor
     */
    public function __construct(){
        parent::__construct(env('AS_PRODUCT_BASE_URL'), env('AS_PRODUCT_SECRET'));
    }

    /**
     * Tambah data product
     *
     * @param Array $params
     * @return Array
     */
    public function create($params){
        return $this->performRequest('POST', 'product', $params);
    }

    /**
     * Baca data product
     *
     * @param Array $params
     * @return Array
    */
    public function read($params=[]){
        return $this->performRequest('GET', 'product', $params);
    }

    /**
     * Mengupdate data product
     *
     * @param Array $params
     * @return Array
     */
    public function update($params=[]){
        return $this->performRequest('PUT', 'product', $params);
    }

    /**
     * Menghapus data product
     *
     * @param Array $params
     * @return Array
     */
    public function delete($params=[]){
        return $this->performRequest('DELETE', 'product', $params);
    }

    // PRODUCT CATEGORY
    /**
     * Menambahkan data category ke dalam database
     * Dan menambahkannya pada produk yang bersangkutan
     *
     * @param Array $params
     * @return Array
     */
    public function addCategory($params=[]){
        return $this->performRequest('POST', 'category', $params);
    }

    /**
     * Mendapatkan data category
     * Digunakan untuk control autocomplete
     *
     * @param Array $params
     * @return Array
     */
    public function getCategory($params=[]){
        return $this->performRequest('GET', 'category', $params);
    }

    /**
     * Menghapus data category dari intermediate table product-category
     *
     * @param Array $params
     * @return Array
     */
    public function removeCategory($params=[]){
        return $this->performRequest('DELETE', 'category', $params);
    }

    // PRODUCT BRAND
    /**
     * Mendapatkan data brand dari database
     * Digunakan untuk control autocomplete
     *
     * @param Array $params
     * @return Array
     */
    public function getBrand($params=[]){
        return $this->performRequest('GET', 'brand', $params);
    }

    // PRODUCT IMAGE
    /**
     * Tambah data image
     *
     * @param Array $params
     * @return Array
     */
    public function addImage($params){
        return $this->performRequest('POST', 'image', $params);
    }

    /**
     * Baca data image
     *
     * @param Array $params
     * @return Array
    */
    public function getImage($params=[]){
        return $this->performRequest('GET', 'image', $params);
    }

    /**
     * Mengupdate data image
     *
     * @param Array $params
     * @return Array
     */
    public function setDefaultImage($params=[]){
        return $this->performRequest('PUT', 'image', $params);
    }

    /**
     * Menghapus data image
     *
     * @param Array $params
     * @return Array
     */
    public function removeImage($params=[]){
        return $this->performRequest('DELETE', 'image', $params);
    }

    // PRODUCT MOVEMENT
    /**
     * Tambah data movement
     *
     * @param Array $params
     * @return Array
     */
    public function createMovement($params){
        return $this->performRequest('POST', 'movement', $params);
    }

    /**
     * Baca data movement
     *
     * @param Array $params
     * @return Array
    */
    public function readMovement($params=[]){
        return $this->performRequest('GET', 'movement', $params);
    }

    /**
     * Menghapus data movement
     *
     * @param Array $params
     * @return Array
     */
    public function deleteMovement($params=[]){
        return $this->performRequest('DELETE', 'movement', $params);
    }


    /**
     * Membaca jenis movement (movement_types)
     * Untuk dipasangkan pada control combobox atau autocomplete
     *
     * @return Array
     */
    public function readMovementType(){
        return $this->performRequest('GET', 'movement/type', []);
    }


    // PRODUCT MOVEMENT DETAIL
    /**
     * Tambah data movement detail
     *
     * @param Array $params
     * @return Array
     */
    public function createMovementDetail($params){
        return $this->performRequest('POST', 'movement/detail', $params);
    }

    /**
     * Baca data movement detail
     *
     * @param Array $params
     * @return Array
    */
    public function readMovementDetail($params=[]){
        return $this->performRequest('GET', 'movement/detail', $params);
    }

    /**
     * Mengupdate data movement detail
     *
     * @param Array $params
     * @return Array
     */
    public function updateMovementDetail($params=[]){
        return $this->performRequest('PUT', 'movement/detail', $params);
    }

    /**
     * Menghapus data movement detail
     *
     * @param Array $params
     * @return Array
     */
    public function deleteMovementDetail($params=[]){
        return $this->performRequest('DELETE', 'movement/detail', $params);
    }


    // PRODUCT MOVEMENT SERIAL
    /**
     * Tambah data serial
     *
     * @param Array $params
     * @return Array
     */
    public function createSerial($params){
        return $this->performRequest('POST', 'movement/serial', $params);
    }

    /**
     * Baca data serial
     *
     * @param Array $params
     * @return Array
    */
    public function readSerial($params=[]){
        return $this->performRequest('GET', 'movement/serial', $params);
    }

    /**
     * Mengupdate data serial
     *
     * @param Array $params
     * @return Array
     */
    public function updateSerial($params=[]){
        return $this->performRequest('PUT', 'movement/serial', $params);
    }

    /**
     * Menghapus data serial
     *
     * @param Array $params
     * @return Array
     */
    public function deleteSerial($params=[]){
        return $this->performRequest('DELETE', 'movement/serial', $params);
    }
}
