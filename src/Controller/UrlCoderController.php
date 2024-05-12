<?php

namespace App\Controller;

use App\Coder\UrlOperator;
use App\Entity\UrlCoderEntity;
use App\Services\UrlService;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/url-coder')]
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

    #[Route('/', name: 'url_coder_index', methods: 'GET')]
    public function index(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(UrlCoderEntity::class);
        $urlCoderList = $repo->findBy(['user' => $this->getUser()]);
        return $this->render('url_coder/index.html.twig', [
            'urlCodeList' => $urlCoderList
        ]);
    }

    #[Route('/get-data', name: 'url_coder_get_data', methods: 'POST')]
    public function getCode(Request $request, EntityManagerInterface $em): Response
    {
        $requestData = $request->get('url') ?: $request->get('code');
        $nonUnique = (bool) $request->get(self::NON_UNIQUE);
        try {
            $data = $this->urlOperator->startApplication($requestData, $nonUnique);
            $urlCoder = $this->urlService->getEntityByCode($data);
            return $this->redirectToRoute('url_coder_item_info', ['id' => $urlCoder->getId()]);
        } catch (Exception|GuzzleException|Error $e) {
            $data = $e->getMessage();
            return $this->render('url_coder/exception-page.html.twig', [
                'data' => $data
            ]);
        }
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

    #[Route('/add-new', name: 'url_coder_add_new')]
    public function addNew(): Response
    {
        return $this->render('url_coder/add-new.html.twig');
    }

    #[Route('/get-url', name: 'url_coder_get_url')]
    public function getUrlByCode(): Response
    {
        return $this->render('url_coder/get-url-by-code.html.twig');
    }

    #[Route('/{id}', name:'url_coder_item_info', requirements: ['id' => '\d+'], methods: 'GET')]
    public function itemInfo(
        int $id,
        UrlCoderEntity $urlCoderEntity
    ): Response
    {
        return $this->render('url_coder/long-item-information.html.twig', [
            'urlCode' => $urlCoderEntity,
        ]);
    }

    #[Route('/remove/{id}', name:'url_coder_remove', requirements: ['id' => '\d+'], methods: 'GET')]
    public function remove(
        int $id,
        UrlCoderEntity $urlCoderEntity,
        EntityManagerInterface $em
    ): Response
    {
        $repo = $em->getRepository(UrlCoderEntity::class);
        $repo->remove($urlCoderEntity);
        return $this->redirectToRoute('url_coder_index');
    }
}
