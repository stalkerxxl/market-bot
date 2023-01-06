<?php

namespace App\Controller;

use App\ApiClient\FmpClient;
use App\Enum\IndexList;
use App\Message\IndexListRequest;
use App\Message\ProfileRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test', name: 'app_test')]
class TestController extends AbstractController
{
    private MessageBusInterface $messageBus;
    private FmpClient $fmpClient;

    public function __construct(MessageBusInterface $messageBus, FmpClient $fmpClient)
    {
        $this->messageBus = $messageBus;
        $this->fmpClient = $fmpClient;
    }

    #[Route('/', name: 'app_test_index')]
    public function index(): Response
    {
        $this->getIndexList(IndexList::SP500);
        //$this->getProfile('META');
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    public function getProfile(string $symbol): Response
    {
        $this->messageBus->dispatch(new ProfileRequest($symbol));

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
}
