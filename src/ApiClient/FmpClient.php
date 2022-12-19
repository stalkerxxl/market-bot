<?php

namespace App\ApiClient;

use App\Exception\FmpClientException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class FmpClient
{
    private HttpClientInterface $client;
    private string $baseUrl;
    private string $apiKey;
    private string $apiVersion = 'v3';
    private string $endpoint = '';

    public function __construct(HttpClientInterface $client, $baseUrl, $apiKey)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     *
     * @throws FmpClientException
     */
    private function _send(): array
    {
        $url = $this->baseUrl . '/' . $this->apiVersion . '/' . $this->endpoint;

        try {
            $response = $this->client->request('GET', $url, ['query' => [
                'apikey' => $this->apiKey
            ]]);
            return $response->toArray();
        } catch (\Symfony\Contracts\HttpClient\Exception\ExceptionInterface $e) {
            throw new FmpClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws FmpClientException
     */
    public function getProfile(string $symbol): array
    {
        $this->endpoint = 'profile/' . strtoupper($symbol);

        return $this->_send();
    }

    /**
     * @throws FmpClientException
     */
    public function getQuote(string $symbol): array
    {
        $this->endpoint = 'quote/' . $symbol;
        return $this->_send();
    }
}