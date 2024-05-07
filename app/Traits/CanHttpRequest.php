<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;

trait CanHttpRequest
{
    /**
     * a guzzle client
     * 
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Contains the last response the request client sent
     * 
     * @var array
     */
    protected $response;

    /**
     * Get the client.
     *
     * @return $client
     *
     */
    public function getClient()
    {
        if ($this->client instanceof Client) {
            return $this->client;
        }

        return new Client;
    }

    /**
     * Set the client.
     *
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Set the response.
     *
     * @return $response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Wrapper for the GET request
     *
     * @param string $endpoint
     * @param array $params
     * @param array @headers
     * @return response
     */
    public function get($endpoint, $params = [], $headers = null)
    {
        return $this->sendRequest(
            'GET',
            $endpoint,
            [
                'json' => $params,
                'headers' => $headers,
            ]
        );
    }

    /**
     * Wrapper for the POST request
     *
     * @param string $endpoint
     * @param array $params
     * @param array @headers
     * @return response
     */
    public function post($endpoint, $params = [], $headers = null)
    {
        return $this->sendRequest('POST', $endpoint, [
            'json' => $params,
            'headers' => $headers,
        ]);
    }

    public function postFormData($endpoint, $params = [], $headers = null)
    {
        return $this->sendRequest('POST', $endpoint, [
            'form_params' => $params,
            'headers' => $headers,
        ]);
    }

    public function postFileUpload($endpoint, $params = [], $headers = null)
    {
        return $this->sendRequest('POST', $endpoint, [
            'multipart' => $params,
            'headers' => $headers,
        ]);
    }

    public function postFileUploadInstitution($endpoint, $data = [], $headers = null)
    {
        $multipart = [
            [
                'name' => 'category',
                'contents' => $data['category']
            ],[
                'name' => 'region_id',
                'contents' => $data['region_id']
            ],[
                'name' => 'library_name',
                'contents' => $data['library_name']
            ],[
                'name' => 'npp',
                'contents' => $data['npp']
            ],[
                'name' => 'agency_name',
                'contents' => $data['agency_name']
            ],[
                'name' => 'address',
                'contents' => $data['address']
            ],[
                'name' => 'province_id',
                'contents' => $data['province_id']
            ],[
                'name' => 'city_id',
                'contents' => $data['city_id']
            ],[
                'name' => 'subdistrict_id',
                'contents' => $data['subdistrict_id']
            ],[
                'name' => 'village_id',
                'contents' => $data['village_id']
            ],[
                'name' => 'institution_head_name',
                'contents' => $data['institution_head_name']
            ],[
                'name' => 'email',
                'contents' => $data['email']
            ],[
                'name' => 'telephone_number',
                'contents' => $data['telephone_number']
            ],[
                'name' => 'mobile_number',
                'contents' => $data['mobile_number']
            ],[
                'name' => 'library_head_name',
                'contents' => $data['library_head_name']
            ],[
                'name' => 'title_count',
                'contents' => $data['title_count']
            ],[
                'name' => 'last_predicate',
                'contents' => $data['last_predicate']
            ],[
                'name' => 'last_certification_date',
                'contents' => $data['last_certification_date']
            ],[
                'name'     => 'registration_form',
                'contents' => fopen($data['registration_form_file']->getRealPath(), 'r'),
                'filename' => $data['registration_form_file']->getClientOriginalName()
            ],
        ];
        foreach ($data['library_worker_name'] as $worker) {
            $multipart[] = [
                'name' => 'library_worker_name[]',
                'contents' => $worker,
            ];
        }
        
        if (isset($data['typology'])) {
            $multipart[] = [
                'name' => 'typology',
                'contents' => $data['typology'],
            ];
        }

        return $this->sendRequest('POST', $endpoint, [
            'multipart' => $multipart,
            'headers' => $headers,
        ]);
    }

    /**
     * Wrapper for the PUT request
     *
     * @param string $endpoint
     * @param array $params
     * @param array @headers
     * @return response
     */
    public function put($endpoint, $ids, $params = [], $headers = null, $endpointParam = null)
    {
        if (!empty($endpointParam)) {
            return $this->sendRequest('PUT', $endpoint . '/' . $ids . '/' . $endpointParam, [
                'json' => $params,
                'headers' => $headers,
            ]);
        }

        return $this->sendRequest('PUT', $endpoint . '/' . $ids, [
            'json' => $params,
            'headers' => $headers,
        ]);
    }

    /**
     * Wrapper for the DELETE request
     *
     * @param string $endpoint
     * @param array $params
     * @param array @headers
     * @return response
     */
    public function delete($endpoint, $params = [], $headers = null, $endpointParam = null, $idParam = null)
    {
        if (!empty($endpointParam)) {
            return $this->sendRequest('DELETE', $endpoint . '/' . $endpointParam . '/' . $idParam, [
                'json' => $params,
                'headers' => $headers,
            ]);
        }

        return $this->sendRequest('DELETE', $endpoint, [
            'json' => $params,
            'headers' => $headers,
        ]);
    }

    /**
     * Perform the HTTP request
     *
     * @param string $method
     * @param string $endpoint
     * @param array $params
     * @return object
     */
    protected function sendRequest($method, $endpoint, $params, $raw = false)
    {
        try {
            $this->attemptRequest();

            // To prevent overwriting, unset headers key if no specified headers present
            if (is_null($params['headers'])) {
                unset($params['headers']);
            }

            $response = $this->getClient()->request($method, $endpoint, $params);

            $this->response = $response;
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
        }

        $statusCode = [200, 201, 400, 422, 401, 404, 500];
        if (!in_array($this->getResponse()->getStatusCode(), $statusCode)) {
            return abort($this->getResponse()->getStatusCode());
        }

        if ($this->getResponse()->getStatusCode() === 401 && $this->shouldTryResend()) {
            return $this->resendRequestWithRefreshedCredential($method, $endpoint, $params, $raw);
        }

        if ($raw) {
            return (string) $this->response->getBody();
        }

        $this->finishRequest();

        return json_decode((string) $this->getResponse()->getBody(), true);
    }

    abstract public function resendRequestWithRefreshedCredential($method, $endpoint, $params, $raw = false);

    abstract public function attemptRequest();

    abstract public function finishRequest();

    abstract public function shouldTryResend(): bool;
}
