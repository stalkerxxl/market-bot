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
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    #[Route('/', name: 'app_test_index')]
    public function index(): Response
    {
        $this->getProfile('META');
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
}
