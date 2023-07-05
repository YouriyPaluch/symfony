<?php

namespace App\Controller;

use App\Coder\UrlOperator;
use App\Entity\UrlCoderEntity;
use App\Services\UrlService;
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
    const NON_UNIQUE = 'non_unique';

    public function __construct(
        protected UrlOperator     $urlOperator,
        protected UrlService      $urlService
    )
    {
    }

    #[Route('/', name: 'url_coder')]
    public function index(): Response
    {
        return $this->render('url_coder/index.html.twig');
    }

    #[Route('/get-data', name: 'url_coder_get_data', methods: 'POST')]
    public function getCode(Request $request): Response
    {
        $requestData = $request->get('url') ?: $request->get('code');
        $nonUnique = (bool) $request->get(self::NON_UNIQUE);
        try {
            $data = $this->urlOperator->startApplication($requestData, $nonUnique);
        } catch (\Exception|GuzzleException $e) {
            $data = $e->getMessage();
        }

        return $this->render('url_coder/show-data.html.twig', [
            'data' => $data
        ]);
    }

    #[Route('/{code}', name:'url_coder_redirect_to_url', requirements: ['code' => '\w{8}'])]
    public function redirectAction(UrlCoderEntity $urlCoderEntity): Response
    {
        $url = $urlCoderEntity->getUrl();
        $this->urlService->incrementCounter($urlCoderEntity);
        return $this->redirect($url);
    }

    #[Route('/{code}/stat', name:'url_coder_statistics', requirements: ['code' => '\w{8}'])]
    public function statisticsAction(UrlCoderEntity $urlCoderEntity): Response
    {
        return new Response($urlCoderEntity->toString());
    }
}
