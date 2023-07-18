<?php

namespace App\Coder;

use App\Entity\User;
use EonX\EasyRandom\RandomGenerator;
use App\Coder\Interfaces\IUrlEncoder;
use App\Coder\Interfaces\IUrlStorage;
use Symfony\Bundle\SecurityBundle\Security;

class UrlEncoder implements IUrlEncoder
{
    /**
     * @param IUrlStorage $storage
     * @param RandomGenerator $randomGenerator
     * @param int $lengthCode
     */
    public function __construct(
        protected IUrlStorage $storage,
        protected Security $security,
        protected RandomGenerator $randomGenerator = new RandomGenerator(),
        protected int $lengthCode = 8
    )
    {}

    /**
     * @param string $url
     * @return string
     * @throws \Exception
     */
    public function encode(string $url): string
    {
        try {
            $code = $this->storage->getCodeByUrl($url);
        } catch (\Exception) {
            $code = $this->generateCode($url);
        }
        return $code;
    }

    /**
     * @param string $url
     * @return string
     * @throws \Exception
     */
    public function generateCode(string $url): string
    {
        $code = $this->randomGenerator
            ->randomString($this->lengthCode)
            ->userFriendly()
            ->__toString();
        $data = [
            'url' => $url,
            'code' => $code,
            'user' => $this->security->getUser(),
        ];
        try {
            $this->storage->saveEntity($data);
        } catch (\Exception $e) {
            throw new \Exception('Something went wrong. ' . $e->getMessage());
        }
        return $code;
    }
}