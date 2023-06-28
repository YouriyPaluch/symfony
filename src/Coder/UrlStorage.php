<?php

namespace App\Coder;

use App\Coder\Interfaces\IUrlStorage;
use App\Entity\UrlCoderEntity;
use App\Repository\UrlCoderEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

class UrlStorage implements IUrlStorage
{
    /**
     * @param UrlCoderEntityRepository $urlCodeRepo
     */
    public function __construct(protected UrlCoderEntityRepository $urlCodeRepo)
    {

    }

    /**
     * @param array $data
     * @return bool
     */
    public function saveEntity(array $data): bool
    {
//        try {
            $entity = UrlCoderEntity::createFromArray($data);
            $this->urlCodeRepo->save($entity, true);
            $result = true;
//        } catch (\Throwable) {
//            $result = false;
//        }
        return $result;
    }

    /**
     * @param string $url
     * @return string
     * @throws \Exception
     */
    public function getCodeByUrl(string $url): string
    {
        return $this->getData(['url' => $url], 'getCode');
    }

    /**
     * @param string $code
     * @return string
     * @throws \Exception
     */
    public function getUrlByCode(string $code): string
    {
        return $this->getData(['code' => $code], 'getUrl');
    }

    /**
     * @param array $criteria
     * @param string $method
     * @return string
     * @throws \Exception
     */
    protected function getData(array $criteria, string $method): string
    {
        try {
            $data = $this->urlCodeRepo->findOneBy($criteria)->{$method}();
        } catch (\Throwable) {
            throw new \InvalidArgumentException();
        }
        return $data;
    }
}