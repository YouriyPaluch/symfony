<?php

namespace App\Controller;

use App\Coder\UrlOperator;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/url-coder', name: 'app_url_coder')]
class UrlCoderController extends AbstractController
{
    const URL = 'url';
    const CODE = 'code';

    #[Route('/', name: 'url_coder')]
    public function index(): Response
    {
        return $this->render('url_coder/index.html.twig');
    }

    #[Route('/get-data', name: 'url_coder_get_data', methods: 'POST')]
    public function getCode(Request $request, UrlOperator $urlOperator): Response
    {
        $requestData = $request->get('url') ?: $request->get('code');
        try {
            $data = $urlOperator->startApplication($requestData);
        } catch (\Exception|GuzzleException $e) {
            $data = $e->getMessage();
        }

        return $this->render('url_coder/show-data.html.twig', [
            'data' => $data
        ]);
    }
}
