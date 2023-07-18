<?php

namespace App\Coder;

use App\Coder\Exceptions\DataNotFoundInDBException;
use App\Coder\Exceptions\NotUrlException;
use GuzzleHttp\Exception\GuzzleException;
use App\Coder\Interfaces\IUrlStorage;

class UrlOperator
{

    /**
     * @param IUrlStorage $storage
     * @param UrlValidator $validator
     * @param UrlEncoder $encoder
     * @param UrlDecoder $decoder
     */
    public function __construct(
        protected IUrlStorage      $storage,
        protected UrlValidator     $validator,
        protected UrlEncoder       $encoder,
        protected UrlDecoder       $decoder
    )
    {}

    /**
     * @param string $url
     * @return string
     * @throws GuzzleException
     * @throws \Exception
     */
    public function getCode(string $url, bool $nonUnique): string
    {
        $this->validator->isWorking($url);
        $code = $nonUnique ? $this->encoder->generateCode($url) : $this->encoder->encode($url);
        return $code;
    }

    /**
     * @param string $code
     * @return string
     */
    public function getUrl(string $code): string
    {
        $this->decoder->decode($code);
        return $code;
    }

    /**
     * @param string $string
     * @param bool $nonUnique
     * @return string
     * @throws GuzzleException
     */
    public function startApplication(string $string, bool $nonUnique): string
    {
        try {
            $this->validator->isUrl($string);
            $result = $this->getCode($string, $nonUnique);
        } catch (NotUrlException $urlException) {
            try {
                $result = $this->getUrl($string);
            } catch (DataNotFoundInDBException $e) {
                $result = 'You input invalid data. ' . $urlException->getMessage() . '; ' . $e->getMessage();
            }
        }
        return $result;
    }


    public function getAllByCriteria(array $criteria)
    {
        return $this->storage->getAllBycriteria($criteria);
    }
}