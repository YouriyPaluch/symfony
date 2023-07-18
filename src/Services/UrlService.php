<?php

namespace App\Services;

use App\Entity\UrlCoderEntity;
use App\Repository\UrlCoderEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\SecurityBundle\Security;

class UrlService {

    /** @var UrlCoderEntityRepository $repository */
    protected ObjectRepository $repository;

    public function __construct(
        protected EntityManagerInterface $em,
        protected Security $security
    )
    {
        $this->repository = $em->getRepository(UrlCoderEntity::class);
    }

    /**
     * @param UrlCoderEntity $urlCoderEntity
     * @return void
     */
    public function incrementCounter(UrlCoderEntity $urlCoderEntity): void
    {
        $urlCoderEntity->incrementCounter();
        $this->repository->save();
    }

    /**
     * @param string $code
     * @return UrlCoderEntity
     */
    public function getEntityByCode(string $code): UrlCoderEntity
    {
        /** @var UrlCoderEntity $urlCoder */
        $urlCoder = $this->repository->findOneBy(['code' => $code, 'user' => $this->security->getUser()]);
        if (is_null($urlCoder)) {
            throw new \Error('You don\'t have permission for watch this data or code not saved');
        }
        return $urlCoder;
    }
}