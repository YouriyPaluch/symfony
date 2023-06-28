<?php

namespace App\Coder;


use App\Coder\Interfaces\IUrlDecoder;
use App\Coder\Interfaces\IUrlStorage;
use Monolog\Logger;
use InvalidArgumentException;

class UrlDecoder implements IUrlDecoder
{

    /**
     * @param IUrlStorage $storage
//     * @param Logger $logger
     */
    public function __construct(
        protected IUrlStorage $storage,
//        protected Logger $logger
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
//            $this->logger->error('Url was not found in file. Exception message: ' . $e->getMessage());
            throw $e;
        }
     }
}