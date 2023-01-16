<?php

namespace App\Tests\Service;

use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MockClientCallback
{
    public function __invoke(string $method, string $url, array $options = []): MockResponse
    {
        //dump($method, $url, $options);
        return new MockResponse(json_encode(['data' => 'foobar2']), ['http_code' => 200]);
    }

}