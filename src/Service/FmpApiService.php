<?php

namespace App\Service;

use App\Enum\IndexList;
use App\Exception\FmpClientException;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FmpApiService
{
    private const API_V3 = 'v3';
    private const API_V4 = 'v4';

    public function __construct(private readonly HttpClientInterface $fmpClient)
    {
    }

    /**
     *
     * @throws FmpClientException
     */
    private function _send(string $endpoint, string $apiVersion = self::API_V3, array $params = []): array
    {
        $url = $apiVersion . '/' . $endpoint . '/';
        try {
            $response = $this->fmpClient->request('GET', $url, ['query' => $params]);
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
        $endpoint = 'profile/' . strtoupper($symbol);
        return $this->_send($endpoint);
    }

    /**
     * @throws FmpClientException
     */
    public function getQuote(string $symbol): array
    {
        $endpoint = 'quote/' . strtoupper($symbol);
        return $this->_send($endpoint);
    }

    /**
     * @throws FmpClientException
     */
    public function getIndexList(IndexList $index): array
    {
        $endpoint = strtolower($index->name) . '_constituent';
        return $this->_send($endpoint);
    }

    /**
     * @throws FmpClientException
     */
    public function getStockPriceChange(string $symbol): array
    {
        $endpoint = 'stock-price-change/' . strtoupper($symbol);
        return $this->_send($endpoint);
    }

    /**
     * @throws FmpClientException
     */
    public function getInsiderRoasterStatistic(string $symbol): array
    {
        $endpoint = 'insider-roaster-statistic';
        $params = [
            'symbol' => strtoupper($symbol)
        ];

        return $this->_send($endpoint, self::API_V4, $params);
    }
}