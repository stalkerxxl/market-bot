<?php

namespace App\Tests\Service;

use App\Enum\IndexList;
use App\Exception\FmpClientException;
use App\Service\FmpApiService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FmpApiServiceTest extends KernelTestCase
{
    private Container $container;
    private ?HttpClientInterface $fmpClient;
    private MockResponse $mockResponse;
    private MockHttpClient $mockHttpClient;
    private const API_URL = 'https://api.url/';
    private FmpApiService $fmpService;

    public static function setUpBeforeClass(): void
    {
        //self::bootKernel();
    }

    protected function setUp(): void
    {
        /*$this->container = static::getContainer();
        $this->fmpClient = $this->container->get('fmp.client');*/

    }

    private function refreshFmpService()
    {
        $this->mockResponse = new MockResponse(json_encode(['data' => 'foobar']));
        $this->mockHttpClient = new MockHttpClient($this->mockResponse, self::API_URL);
        $this->fmpService = new FmpApiService($this->mockHttpClient);
    }

    /**
     * @covers FmpApiService::getProfile
     * @covers FmpApiService::getQuote
     * @covers FmpApiService::getIndexList
     * @covers FmpApiService::getStockPriceChange
     * @covers FmpApiService::getInsiderRoasterStatistic
     * @throws FmpClientException
     */

    public function testAllEndpointsUrlsIsCorrect(): void
    {
        $this->refreshFmpService();
        $this->fmpService->getProfile('aapl');
        $this->assertSame(self::API_URL . 'v3/profile/AAPL/',
            $this->mockResponse->getRequestUrl());

        $this->refreshFmpService();
        $this->fmpService->getQuote('aapl');
        $this->assertSame(self::API_URL . 'v3/quote/AAPL/',
            $this->mockResponse->getRequestUrl());

        $this->refreshFmpService();
        $this->fmpService->getIndexList(IndexList::SP500);
        $this->assertSame(self::API_URL . 'v3/sp500_constituent/',
            $this->mockResponse->getRequestUrl());

        $this->refreshFmpService();
        $this->fmpService->getStockPriceChange('aapl');
        $this->assertSame(self::API_URL . 'v3/stock-price-change/AAPL/',
            $this->mockResponse->getRequestUrl());

        $this->refreshFmpService();
        $this->fmpService->getInsiderRoasterStatistic('aapl');
        $this->assertSame(
            self::API_URL . 'v4/insider-roaster-statistic/?symbol=AAPL',
            $this->mockResponse->getRequestUrl()
        );
    }
}
