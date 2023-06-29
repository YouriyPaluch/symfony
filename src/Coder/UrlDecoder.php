<?php

namespace App\Coder;


use App\Coder\Interfaces\IUrlDecoder;
use App\Coder\Interfaces\IUrlStorage;
use InvalidArgumentException;

class UrlDecoder implements IUrlDecoder
{

    /**
     * @param IUrlStorage $storage
     */
    public function __construct(
        protected IUrlStorage $storage
    )
    {}

    /**
     * @param string $code
     * @throws InvalidArgumentException
     * @return string
     */
    public function decode(string $code): string
    {
        try {
            return $this->storage->getUrlByCode($code);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException('Url was not found in DB. Exception message: ' . $e->getMessage());
        }
     }
}