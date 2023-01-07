<?php

namespace App\ApiClient;

use App\Enum\IndexList;
use App\Exception\FmpClientException;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FmpClient
{
    private HttpClientInterface $client;
    private string $baseUrl;
    private string $apiKey;
    private string $apiVersion = 'v3';
    private string $endpoint = '';
    private array $params;

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
        $this->params['apikey'] = $this->apiKey;

        try {
            $response = $this->client->request('GET', $url, ['query' => $this->params]);
            return $response->toArray();
        } catch (ExceptionInterface $e) {
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

    /**
     * @throws FmpClientException
     */
    public function getIndexList(IndexList $index): array
    {
        $this->endpoint = strtolower($index->name) . '_constituent';
        return $this->_send();
    }

    /**
     * @throws FmpClientException
     */
    public function getStockPriceChange(string $symbol): array
    {
        $this->endpoint = 'stock-price-change/' . $symbol;
        return $this->_send();
    }

    /**
     * @throws FmpClientException
     */
    public function getInsiderRoasterStatistic(string $symbol): array
    {
        $this->apiVersion = 'v4';
        $this->endpoint = 'insider-roaster-statistic/';
        $this->params = [
            'symbol' => strtoupper($symbol)
        ];

        return $this->_send();
    }
}