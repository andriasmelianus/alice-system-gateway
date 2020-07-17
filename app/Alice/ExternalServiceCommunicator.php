<?php

namespace App\Alice;

use GuzzleHttp\Client;

class ExternalServiceCommunicator
{

    private $baseUri;
    private $secret;

    /**
     * Constructor
     *
     * @param String $baseUri
     * @param String $secret
     */
    public function __construct($baseUri, $secret)
    {
        $this->baseUri = $baseUri;
        $this->secret = $secret;
    }

    /**
     * Menjalankan request dari Gateway ke service lain
     *
     * @param String $method
     * @param String $requestUrl
     * @param array $params
     * @return void
     */
    public function performRequest($method, $requestUrl, $params)
    {
        $client = new Client([
            'base_uri' => $this->baseUri
        ]);

        /**
         * Pemasangan secret
         */
        if (isset($this->secret)) {
            $params['headers'] = [
                'Authorization' => "Bearer {$this->secret}"
            ];
        }

        $response = $client->request($method, $requestUrl, $params);

        return $response->getBody()->getContents();
    }
}
