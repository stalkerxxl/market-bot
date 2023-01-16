<?php

namespace App\Tests\Message;

use App\Message\CompanyRequest;
use App\MessageHandler\CompanyRequestHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CompanyRequestTest extends KernelTestCase
{
    public function test_test()
    {
        self::bootKernel();
        $container = static::getContainer();
        //dump($container->get('validator'));
        $messengerBus = $container->get('messenger.bus.default');
        $messengerBus->dispatch(new CompanyRequest('AAPL'));
        //dump($messengerBus->getDispatchedMessages());
        //call_user_func($companyRequestHandler, new CompanyRequest('AAPL'));
        $this->assertTrue(true);
    }
}
