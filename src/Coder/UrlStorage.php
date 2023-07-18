<?php

namespace App\Coder;

use App\Coder\Exceptions\EntityNotSaveException;
use App\Coder\Interfaces\IUrlStorage;
use App\Entity\UrlCoderEntity;
use App\Entity\User;
use App\Repository\UrlCoderEntityRepository;
use Symfony\Bundle\SecurityBundle\Security;

class UrlStorage implements IUrlStorage
{
    /**
     * @param UrlCoderEntityRepository $urlCodeRepo
     */
    public function __construct(
        protected UrlCoderEntityRepository $urlCodeRepo,
        protected Security $security
    )
    {

    }

    /**
     * @param array $data
     * @return void
     * @throws EntityNotSaveException
     */
    public function saveEntity(array $data): void
    {
        try {
            $entity = UrlCoderEntity::createFromArray($data);
            $this->urlCodeRepo->save($entity);
        } catch (\Throwable) {
            throw new EntityNotSaveException();
        }
    }

    /**
     * @param string $url
     * @return string
     */
    public function getCodeByUrl(string $url): string
    {
        /** @var User $user */
        $user = $this->security->getUser();
        return $this->getData(['url' => $url, 'user' => $user], 'getCode');
    }

    /**
     * @param string $code
     * @return string
     */
    public function getUrlByCode(string $code): string
    {
        return $this->getData(['code' => $code], 'getUrl');
    }

    /**
     * @param array $criteria
     * @param string $method
     * @return string
     */
    protected function getData(array $criteria, string $method): string
    {
        try {
            $data = $this->urlCodeRepo->findOneBy($criteria)->{$method}();
        } catch (\Throwable) {
            throw new \InvalidArgumentException('Searching data: ' . json_encode($criteria));
        }
        return $data;
    }
}