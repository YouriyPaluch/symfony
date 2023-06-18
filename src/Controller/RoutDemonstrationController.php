<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoutDemonstrationController extends AbstractController
{
    #[Route('/rout/demonstration', name: 'app_rout_demonstration')]
    public function index(): Response
    {
        return $this->render('rout/index.html.twig', [
            'controller_name' => 'RoutDemonstrationController',
        ]);
    }

    #[Route('/rout/show-input-text', name: 'app_rout_show_input_text')]
    public function showInputText(Request $request): Response
    {
        $string = $request->query->get('word');
        return $this->render('rout/show-input-text.html.twig', [
            'string' => $string,
        ]);
    }
}
