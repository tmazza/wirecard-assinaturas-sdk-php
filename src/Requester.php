<?php

namespace WirecardSubscription;

use GuzzleHttp\Exception\ClientException;
use WirecardSubscription\Exceptions\ValidationException;

class Requester
{
    protected $client;
    private $lastResponse;
    private $querys = [];

    public function __construct($env = null, $token = null, $key = null)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->baseUrl($env),
            'auth' => [$this->authToken($token), $this->authKey($key)],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function send(string $method, string $url, array $options = [])
    {
        try {
            $options['query'] = array_merge($this->querys, $options['query'] ?? []);
            $response = $this->client->request($method, $url, $options);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } finally {
            $this->clearQuerys();
        }
                
        return $this->toResponse($response);
    }

    public function addQuerys(array $querys = [])
    {
        $this->querys = array_merge($this->querys, $querys);
    }

    public function lastResponse()
    {
        return $this->lastResponse;
    }

    private function clearQuerys()
    {
        $this->querys = [];
    }

    private function baseUrl($env)
    {
        return ($env ?? getenv('WIRECARD_SUBSCRIPTIONS_ENV')) === 'production'
            ? 'https://api.moip.com.br/assinaturas/v1/'
            : 'https://sandbox.moip.com.br/assinaturas/v1/';
    }

    private function authToken($token)
    {
        return $token ?? getenv('WIRECARD_SUBSCRIPTIONS_TOKEN');
    }
    
    private function authKey($key)
    {
        return $key ?? getenv('WIRECARD_SUBSCRIPTIONS_KEY');
    }

    private function toResponse($response)
    {
        $this->lastResponse = $response;
        
        $status = $response->getStatusCode();
        $data = json_decode((string) $response->getBody(), false);

        if ($status === 400) {
            throw new ValidationException($data);
        }

        return new Response($status, $data);
    }
}
