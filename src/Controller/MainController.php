<?php

namespace App\Controller;

use App\Coder\UrlOperator;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @throws GuzzleException
     */
    #[Route('/coder', name: 'app_main')]
    public function coder(UrlOperator $urlOperator): Response
    {
        $urlOperator->startApplication('https://google.com');
        return $this->render('main/index.html.twig', [
            'controller_name' => $urlOperator->getUrlCode('https://google.com'),
        ]);
    }
}
