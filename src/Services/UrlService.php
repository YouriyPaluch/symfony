<?php

namespace App\Services;

use App\Entity\UrlCoderEntity;
use App\Repository\UrlCoderEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UrlService {

    /** @var UrlCoderEntityRepository $repository */
    protected ObjectRepository $repository;

    public function __construct(protected EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(UrlCoderEntity::class);
    }

    public function incrementCounter(UrlCoderEntity $urlCoderEntity): void
    {
        $urlCoderEntity->incrementCounter();
        $this->repository->save();
    }

}