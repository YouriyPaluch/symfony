<?php

namespace App\Coder;


use App\Coder\Exceptions\DataNotFoundInDBException;
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
        } catch (InvalidArgumentException) {
            throw new DataNotFoundInDBException('Code - ' . $code . ' was not found in DB.');
        }
     }
}