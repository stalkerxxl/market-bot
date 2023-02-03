<?php

namespace App\Tests;

use App\DataFixtures\CompanyFixtures;
use App\Entity\Company;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FastTest extends KernelTestCase
{
    private ContainerInterface|Container $container;
    private EntityManager $em;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->container = static::getContainer();
        $this->em = $this->container->get(EntityManagerInterface::class);
    }

    public function testValidator()
    {
        $f = new CompanyFixtures();
        $f->load($this->em);
        //self::markTestIncomplete();
       $res = $this->em->getRepository(Company::class)->findOneBy(['symbol'=>'AAPL']);
        //self::$companyRepository->save($entity, true);
        //dump($res);

    }

}
