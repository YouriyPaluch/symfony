<?php

namespace App\Coder;


use App\Coder\Interfaces\IUrlDecoder;
use App\Coder\Interfaces\IUrlStorage;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use InvalidArgumentException;

class UrlDecoder implements IUrlDecoder
{

    /**
     * @param IUrlStorage $storage
     * @param Logger $logger
     */
    public function __construct(
        protected IUrlStorage $storage,
        protected Logger $logger
    )
    {
        $logger->pushHandler(new StreamHandler('logs/log.log', Level::Notice));
    }

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
            $this->logger->error('Url was not found in DB. Exception message: ' . $e->getMessage());
            throw new InvalidArgumentException('Url was not found in DB. Exception message: ' . $e->getMessage());
        }
     }
}