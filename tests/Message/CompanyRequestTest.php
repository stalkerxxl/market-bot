<?php

namespace App\Tests\Message;

use App\DataFixtures\CompanyFixtures;
use App\Entity\Company;
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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;
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
            ->willReturn(CompanyFixtures::getData()['valid']);
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
            ->willReturn(CompanyFixtures::getData()['empty']);
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
            ->willReturn(CompanyFixtures::getData()['invalid']);
        $this->container->set(FmpApiService::class, $this->mockFmpApiService);

        $this->expectException(HandlerFailedException::class);
        $this->messageBus->dispatch(new CompanyRequest('AAPL'));
    }
}
