<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Alice\ApiResponser;
use App\Alice\ExternalServices\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $apiResponser;
    private $contact;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiResponser $apiResponser, Contact $contact)
    {
        $this->apiResponser = $apiResponser;
        $this->contact = $contact;
    }


    /**
     * Menambah data phone
     *
     * @param Request $request
     * @return void
     */
    public function createPhone(Request $request)
    {
        $phone = $this->contact->createPhone([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($phone);
    }

    /**
     * Membaca data phone
     *
     * @param Request $request
     * @return void
     */
    public function readPhone(Request $request)
    {
        $phone = $this->contact->readPhone([
            'query' => ['keyword' => $request->input('keyword')]
        ]);

        return $this->apiResponser->success($phone);
    }

    /**
     * Mengubah data phone
     *
     * @param Request $request
     * @return void
     */
    public function updatePhone(Request $request)
    {
        $phone = $this->contact->updateAddress([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($phone);
    }

    /**
     * Menghapus data phone
     *
     * @param Request $request
     * @return void
     */
    public function deletePhone(Request $request)
    {
        $phone = $this->contact->deletePhone([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($phone);
    }


    /**
     * Menambah data address
     *
     * @param Request $request
     * @return void
     */
    public function createAddress(Request $request)
    {
        $address = $this->contact->createAddress([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($address);
    }

    /**
     * Membaca data address
     *
     * @param Request $request
     * @return void
     */
    public function readAddress(Request $request)
    {
        $address = $this->contact->readAddress([
            'query' => ['keyword' => $request->input('keyword')]
        ]);

        return $this->apiResponser->success($address);
    }

    /**
     * Mengubah data address
     *
     * @param Request $request
     * @return void
     */
    public function updateAddress(Request $request)
    {
        $address = $this->contact->updateAddress([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($address);
    }

    /**
     * Menghapus data address
     *
     * @param Request $request
     * @return void
     */
    public function deleteAddress(Request $request)
    {
        $address = $this->contact->deleteAddress([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($address);
    }

    /**
     * Menambah data city
     *
     * @param Request $request
     * @return void
     */
    public function createCity(Request $request)
    {
        $city = $this->contact->createCity([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($city);
    }

    /**
     * Membaca data city
     *
     * @param Request $request
     * @return void
     */
    public function readCity(Request $request)
    {
        $city = $this->contact->readCity([
            'query' => ['keyword' => $request->input('keyword')]
        ]);

        return $this->apiResponser->success($city);
    }

    /**
     * Mengubah data city
     *
     * @param Request $request
     * @return void
     */
    public function updateCity(Request $request)
    {
        $city = $this->contact->updateCity([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($city);
    }

    /**
     * Menghapus data city
     *
     * @param Request $request
     * @return void
     */
    public function deleteCity(Request $request)
    {
        $city = $this->contact->deleteCity([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($city);
    }


    /**
     * Menambah data region
     *
     * @param Request $request
     * @return void
     */
    public function createRegion(Request $request)
    {
        $region = $this->contact->createRegion([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($region);
    }

    /**
     * Membaca data region
     *
     * @param Request $request
     * @return void
     */
    public function readRegion(Request $request)
    {
        $region = $this->contact->readRegion([
            'query' => ['keyword' => $request->input('keyword')]
        ]);

        return $this->apiResponser->success($region);
    }

    /**
     * Mengubah data region
     *
     * @param Request $request
     * @return void
     */
    public function updateRegion(Request $request)
    {
        $region = $this->contact->updateRegion([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($region);
    }

    /**
     * Menghapus data region
     *
     * @param Request $request
     * @return void
     */
    public function deleteRegion(Request $request)
    {
        $region = $this->contact->deleteRegion([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($region);
    }


    /**
     * Menambah data country
     *
     * @param Request $request
     * @return void
     */
    public function createCountry(Request $request)
    {
        $country = $this->contact->createCountry([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($country);
    }

    /**
     * Membaca data country
     *
     * @param Request $request
     * @return void
     */
    public function readCountry(Request $request)
    {
        $country = $this->contact->readCountry([
            'query' => ['keyword' => $request->input('keyword')]
        ]);

        return $this->apiResponser->success($country);
    }

    /**
     * Mengubah data country
     *
     * @param Request $request
     * @return void
     */
    public function updateCountry(Request $request)
    {
        $country = $this->contact->updateCountry([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($country);
    }

    /**
     * Menghapus data country
     *
     * @param Request $request
     * @return void
     */
    public function deleteCountry(Request $request)
    {
        $country = $this->contact->deleteCountry([
            'form_params' => $request->all()
        ]);

        return $this->apiResponser->success($country);
    }
}
