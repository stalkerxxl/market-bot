<?php

namespace App\Tests\Message;

use App\Message\CompanyRequest;
use App\Repository\CompanyRepository;
use App\Service\FmpApiService;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\TraceableMessageBus;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\once;

/**
 * 1. Валидные данные
 * 2. Response = []
 * 3. Невалидные данные
 * @covers \App\Message\CompanyRequest
 * @covers \App\MessageHandler\CompanyRequestHandler
 */
class CompanyRequestTest extends KernelTestCase
{
    private static CompanyRepository $companyRepository;
    private static array $stubResponse;
    private TraceableMessageBus $messageBus;
    private ContainerInterface|Container $container;
    private MockObject|FmpApiService $mockFmpApiService;

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass(): void
    {
        self::$companyRepository = static::getContainer()->get(CompanyRepository::class);
        self::$stubResponse = [
            'valid' => [[
                "symbol" => "AAPL",
                "price" => 137.87,
                "beta" => 1.27241,
                "volAvg" => 81738286,
                "mktCap" => 2183336820736,
                "lastDiv" => 0.91,
                "range" => "124.17-179.61",
                "changes" => 2.5999908,
                "companyName" => "Apple Inc.",
                "currency" => "USD",
                "cik" => "0000320193",
                "isin" => "US0378331005",
                "cusip" => "037833100",
                "exchange" => "NASDAQ Global Select",
                "exchangeShortName" => "NASDAQ",
                "industry" => "Consumer Electronics",
                "website" => "https://www.apple.com",
                "description" => "Apple Inc. designs, manufactures, and markets smartphones, personal computers, tablets, wearables, and accessories worldwide. It also sells various related services. In addition, the company offers iPhone, a line of smartphones; Mac, a line of personal computers; iPad, a line of multi-purpose tablets; and wearables, home, and accessories comprising AirPods, Apple TV, Apple Watch, Beats products, and HomePod. Further, it provides AppleCare support and cloud services store services; and operates various platforms, including the App Store that allow customers to discover and download applications and digital content, such as books, music, video, games, and podcasts. Additionally, the company offers various services, such as Apple Arcade, a game subscription service; Apple Fitness+, a personalized fitness service; Apple Music, which offers users a curated listening experience with on-demand radio stations; Apple News+, a subscription news and magazine service; Apple TV+, which offers exclusive original content; Apple Card, a co-branded credit card; and Apple Pay, a cashless payment service, as well as licenses its intellectual property. The company serves consumers, and small and mid-sized businesses; and the education, enterprise, and government markets. It distributes third-party applications for its products through the App Store. The company also sells its products through its retail and online stores, and direct sales force; and third-party cellular network carriers, wholesalers, retailers, and resellers. Apple Inc. was incorporated in 1977 and is headquartered in Cupertino, California.",
                "ceo" => "Mr. Timothy Cook",
                "sector" => "Technology",
                "country" => "US",
                "fullTimeEmployees" => "164000",
                "phone" => "14089961010",
                "address" => "1 Apple Park Way",
                "city" => "Cupertino",
                "state" => "CALIFORNIA",
                "zip" => "95014",
                "dcfDiff" => 12.2118,
                "dcf" => 150.082,
                "image" => "https://financialmodelingprep.com/image-stock/AAPL.png",
                "ipoDate" => "1980-12-12",
                "defaultImage" => false,
                "isEtf" => false,
                "isActivelyTrading" => true,
                "isAdr" => false,
                "isFund" => false
            ]],
            'invalid' => [[
                "symbol" => "AAPL",
                "price" => null,
                "beta" => null,
            ]],
            'empty' => []
        ];
    }

    protected function setUp(): void
    {
        assertSame([], self::$companyRepository->findAll());
        self::bootKernel();
        $this->container = static::getContainer();
        $this->messageBus = static::getContainer()->get(MessageBusInterface::class);
        $this->mockFmpApiService = $this->createMock(FmpApiService::class);
    }

    /**
     * @throws \Throwable
     */
    public function testIfApiResponseIsValid()
    {
        $this->mockFmpApiService->expects(once())
            ->method('getProfile')
            ->willReturn(self::$stubResponse['valid']);
        $this->container->set(FmpApiService::class, $this->mockFmpApiService);

        $this->messageBus->dispatch(new CompanyRequest('AAPL'));
        $entity = self::$companyRepository->findOneBy(['symbol' => 'AAPL']);

        assertSame('AAPL', $entity->getSymbol());
    }

    /**
     * @throws \Throwable
     */
    public function testIfApiResponseIsEmpty()
    {
        $this->mockFmpApiService->expects(once())
            ->method('getProfile')
            ->willReturn(self::$stubResponse['empty']);
        $this->container->set(FmpApiService::class, $this->mockFmpApiService);

        $this->expectException(HandlerFailedException::class);
        $this->expectExceptionMessage('Undefined array key 0');
        $this->messageBus->dispatch(new CompanyRequest('AAPL'));
    }

    /**
     * @throws \Throwable
     */
    public function testIfApiResponseIsInvalid()
    {
        $this->mockFmpApiService->expects(once())
            ->method('getProfile')
            ->willReturn(self::$stubResponse['invalid']);
        $this->container->set(FmpApiService::class, $this->mockFmpApiService);

        $this->expectException(HandlerFailedException::class);
        $this->messageBus->dispatch(new CompanyRequest('AAPL'));
    }
}
