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
    public function getUrlCode(string $url): string
    {
        $this->validator->isWorking($url);
        $code = $this->encoder->encode($url);
        return 'This URL: ' . $url . ' has a code. Code: ' . $code;
    }

    /**
     * @param string $code
     * @return string
     */
    public function getUrl(string $code): string
    {
        return $this->decoder->decode($code);
    }

    /**
     * @param string $string
     * @return string
     * @throws GuzzleException
     */
    public function startApplication(string $string): string
    {
        try {
            $this->validator->isUrl($string);
            $result = $this->getUrlCode($string);
        } catch (NotUrlException $urlException) {
            try {
                $result = $this->getUrl($string);
            } catch (DataNotFoundInDBException $e) {
                $result = 'You input invalid data. ' . $urlException->getMessage() . '; ' . $e->getMessage();
            }
        }
        return $result;
    }
}