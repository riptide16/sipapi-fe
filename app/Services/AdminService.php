<?php

namespace App\Services;

use App\Traits\CanHttpRequest;
use GuzzleHttp\Client;

class AdminService
{
    use CanHttpRequest;

    protected $attempt = 0;

    /**
     * Create elena class instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.api.url'),
            'headers' => $this->getDefaultHeaders(),
        ]);
    }

    /**
     * Get default headers for Client.
     *
     * @return array
     */
    public function getDefaultHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'client-user-agent' => request()->server('HTTP_USER_AGENT'),
            'client-ip' => request()->ip()
        ];
    }

     /**
     * Create new elena data.
     *
     * @param  string $endpoint
     * @param  array  $data
     * @return array
     */
    public function getAll($endpoint, $params = [], $headers = null)
    {
        return $this->get($endpoint, $params, $headers);
    }

    public function downloadFile($endpoint, $headers = null)
    {
        return $this->sendRequest('GET', $endpoint, [
            'headers' => $headers,
        ], true);
    }

    public function getByID($endpoint, $billingId = null, $params = [], $headers = null, $endpointParam = null)
    {
        if (!empty($endpointParam)) {
            return $this->get($endpoint . '/' . $billingId . '/' . $endpointParam, $params, $headers);
        }
        return $this->get($endpoint . '/' . $billingId, $params, $headers, $endpointParam);
    }

    public function createNew($endpoint, $data, $headers = null)
    {
        return $this->post($endpoint, $data, $headers);
    }

    public function updateByID($endpoint, $billingId, $data, $headers = null, $endpointParam = null)
    {
        return $this->put($endpoint, $billingId, $data, $headers, $endpointParam);
    }

    public function deleteByID($endpoint, $billingId, $headers = null, $endpointParam = null, $idParama = null)
    {
        return $this->delete($endpoint . '/' . $billingId, [], $headers, $endpointParam, $idParama);
    }

    public function storeInstitution($endpoint, $data, $headers = null)
    {
        return $this->postFileUploadInstitution($endpoint, $data, $headers);
    }

    public function formData($endpoint, $data, $headers = null)
    {
        return $this->postFileUpload($endpoint, $data, $headers);
    }

    public function refreshToken()
    {
        $refreshToken = session('token.data.refresh_token');
        if (!$refreshToken) {
            return;
        }

        if ($this->attempt > 0) {
            $this->attempt--;
        }

        $param = [
            'client_id' => config('services.api.client_id'),
            'client_secret' => config('services.api.client_secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];
        $result = $this->createNew('auth/token', $param);
        if ($result['success'] === true) {
            session(['token' => $result]);
        }
    }

    public function resendRequestWithRefreshedCredential($method, $endpoint, $params, $raw = false)
    {
        $this->refreshToken();

        $params['headers']['Authorization'] = "Bearer " . session('token.data.access_token');
        return $this->sendRequest($method, $endpoint, $params, $raw);
    }

    public function shouldTryResend(): bool
    {
        return $this->attempt < 2;
    }

    public function attemptRequest()
    {
        $this->attempt++;
    }

    public function finishRequest()
    {
        $this->attempt--;
    }
}
