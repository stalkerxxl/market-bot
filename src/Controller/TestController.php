<?php

namespace App\Controller;

use App\Message\ProfileRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test', name: 'app_test')]
class TestController extends AbstractController
{
    #[Route('/', name: 'app_test_index')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('/get-profile/{symbol}', name: 'app_test_get_profile')]
    public function getProfile(string $symbol, MessageBusInterface $messageBus){
        $messageBus->dispatch(new ProfileRequest($symbol));

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);

    }
}
