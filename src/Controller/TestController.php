<?php

namespace App\Controller;

use App\ApiClient\FmpClient;
use App\Entity\Company;
use App\Enum\IndexList;
use App\Message\DownloadCompanyLogo;
use App\Message\IndexListRequest;
use App\Message\PerformanceRequest;
use App\Message\CompanyRequest;
use App\Message\RoasterRequest;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test', name: 'app_test')]
class TestController extends AbstractController
{
    private MessageBusInterface $messageBus;
    private FmpClient $fmpClient;
    private EntityManagerInterface $entityManager;

    public function __construct(MessageBusInterface $messageBus, FmpClient $fmpClient, EntityManagerInterface $entityManager)
    {
        $this->messageBus = $messageBus;
        $this->fmpClient = $fmpClient;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_test_index')]
    public function index(): Response
    {
        $this->getRoasters();
        //$this->getPerformance();
        //$this->getCompanyLogo();
        //$this->getIndexList(IndexList::SP500);
        //$this->getProfile('META');
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    public function getProfile(string $symbol): Response
    {
        $this->messageBus->dispatch(new CompanyRequest($symbol));

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    public function getIndexList(IndexList $index)
    {
        $this->messageBus->dispatch(new IndexListRequest($index));
        /* $data = $this->fmpClient->getIndexList($index);
         dump(array_column($data,'symbol'));*/
    }

    public function getPerformance()
    {
        $repo = $this->entityManager->getRepository(Company::class);
        $data = $repo->findAll();
        $unique = array_map(function ($item) {
            return $item->getId();
        }, $data);

        foreach ($unique as $companyId) {
            $this->messageBus->dispatch(new PerformanceRequest($companyId));
        }
    }

    public function getCompanyLogo()
    {
        $repo = $this->entityManager->getRepository(Company::class);
        $data = $repo->findAll();
        $unique = array_map(function ($item) {
            return $item->getId();
        }, $data);

        foreach ($unique as $companyId) {
            $this->messageBus->dispatch(new DownloadCompanyLogo($companyId));
        }
    }

    public function getRoasters(){
        $this->messageBus->dispatch(new RoasterRequest(1));
    }
}
