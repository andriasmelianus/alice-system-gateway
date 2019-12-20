<?php
namespace App\Alice\ExternalServices;

use App\Alice\ExternalServiceCommunicator;

class Contact extends ExternalServiceCommunicator {

    /**
     * Constructor
     */
    public function __construct(){
        parent::__construct('http://contacts.local', 'wGQzPZ8u8ZWEpUNRgEekxqrjbXLQLTbn');
    }


    /**
     * Tambah data phone
     *
     * @param Array $data
     * @return void
     */
    public function createPhone($params){
        return $this->performRequest('POST', 'phone', $params);
    }

    /**
     * Baca data phone
     *
     * @param array $data
     * @return void
    */
    public function readPhone($params=[]){
        return $this->performRequest('GET', 'phone', $params);
    }

    /**
     * Mengupdate data phone
     *
     * @param array $params
     * @return void
     */
    public function updatePhone($params=[]){
        return $this->performRequest('PUT', 'phone', $params);
    }

    /**
     * Menghapus data phone
     *
     * @param array $params
     * @return void
     */
    public function deletePhone($params=[]){
        return $this->performRequest('DELETE', 'phone', $params);
    }


    /**
     * Tambah data address
     *
     * @param Array $data
     * @return void
     */
    public function createAddress($params){
       return $this->performRequest('POST', 'address', $params);
    }

    /**
     * Baca data address
     *
     * @param array $data
     * @return void
    */
    public function readAddress($params=[]){
        return $this->performRequest('GET', 'address', $params);
    }

    /**
     * Mengupdate data address
     *
     * @param array $params
     * @return void
     */
    public function updateAddress($params=[]){
        return $this->performRequest('PUT', 'address', $params);
    }

    /**
     * Menghapus data address
     *
     * @param array $params
     * @return void
     */
    public function deleteAddress($params=[]){
        return $this->performRequest('DELETE', 'address', $params);
    }


    /**
     * Tambah data city
     *
     * @param Array $data
     * @return void
     */
    public function createCity($params){
        return $this->performRequest('POST', 'city', $params);
    }

    /**
     * Baca data city
     *
     * @param array $data
     * @return void
    */
    public function readCity($params=[]){
        return $this->performRequest('GET', 'city', $params);
    }

     /**
      * Mengupdate data address
      *
      * @param array $params
      * @return void
      */
    public function updateCity($params=[]){
        return $this->performRequest('PUT', 'city', $params);
    }

    /**
     * Menghapus data address
     *
     * @param array $params
     * @return void
     */
    public function deleteCity($params=[]){
        return $this->performRequest('DELETE', 'address', $params);
    }


    /**
     * Tambah data region
     *
     * @param Array $data
     * @return void
     */
    public function createRegion($params){
        return $this->performRequest('POST', 'region', $params);
    }

    /**
     * Baca data region
     *
     * @param array $data
     * @return void
     */
    public function readRegion($params=[]){
        return $this->performRequest('GET', 'region', $params);
    }

    /**
     * Mengupdate data region
     *
     * @param array $params
     * @return void
     */
    public function updateRegion($params=[]){
        return $this->performRequest('PUT', 'region', $params);
    }

    /**
     * Menghapus data region
     *
     * @param array $params
     * @return void
     */
    public function deleteRegion($params=[]){
         return $this->performRequest('DELETE', 'region', $params);
    }



    /**
     * Tambah data country
     *
     * @param Array $data
     * @return void
     */
    public function createCountry($params){
        return $this->performRequest('POST', 'country', $params);
    }

    /**
     * Baca data country
     *
     * @param array $data
     * @return void
     */
    public function readCountry($params=[]){
        return $this->performRequest('GET', 'country', $params);
    }

    /**
     * Mengupdate data country
     *
     * @param array $params
     * @return void
     */
    public function updateCountry($params=[]){
        return $this->performRequest('PUT', 'country', $params);
    }

    /**
     * Menghapus data country
     *
     * @param array $params
     * @return void
     */
    public function deleteCountry($params=[]){
         return $this->performRequest('DELETE', 'country', $params);
    }
}
