<?php

namespace App\Tests\Message;

use App\Message\CompanyRequest;
use App\Repository\CompanyRepository;
use App\Service\FmpApiService;
use PHPUnit\Framework\Assert;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\TraceableMessageBus;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\once;

/**
 * 1. Валидные данные
 * 2. Response = []
 * 3. ResponseDTO не прошел валидацию
 * 4. Вызов события CompanyUpdatedEvent
 * 5. Валидация на запрет дублей в Company
 */
class CompanyRequestTest extends KernelTestCase
{
    private static CompanyRepository $companyRepository;
    private TraceableMessageBus $messageBus;
    private ContainerInterface|Container $container;
    private TraceableEventDispatcher $eventDispatcher;

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass(): void
    {
        self::$companyRepository = static::getContainer()->get(CompanyRepository::class);
    }

    protected function setUp(): void
    {
        assertSame([], self::$companyRepository->findAll());
        self::bootKernel();
        $this->container = static::getContainer();
        $this->messageBus = static::getContainer()->get(MessageBusInterface::class);
    }

    private function getValidResponse(): array
    {
        return [
            [
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
            ]
        ];
    }

    /**
     * @throws \Throwable
     */
    public function testIfAllLogicOk()
    {
        $mockFmpService = $this->createMock(FmpApiService::class);
        $mockFmpService->expects(once())
            ->method('getProfile')
            ->willReturn($this->getValidResponse());
        $this->container->set(FmpApiService::class, $mockFmpService);

        $this->messageBus->dispatch(new CompanyRequest('AAPL'));
        $entity = self::$companyRepository->findOneBy(['symbol' => 'AAPL']);

        assertSame('AAPL', $entity->getSymbol());
    }

    public function testIfApiResponseIsNotOk()
    {
        $mockFmpService = $this->createMock(FmpApiService::class);
        $mockFmpService->expects(once())
            ->method('getProfile')
            ->willReturn($this->getValidResponse());
        $this->container->set(FmpApiService::class, $mockFmpService);
        /* self::markTestIncomplete();*/
        $this->messageBus->dispatch(new CompanyRequest('AAPL'));
        //self::markTestIncomplete();
        $entity = self::$companyRepository->findOneBy(['symbol' => 'AAPL']);
        //3. asserts
        assertSame('AAPL', $entity->getSymbol());
    }
}
