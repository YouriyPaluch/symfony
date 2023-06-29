<?php

namespace App\Coder;

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
        if (empty($string)) {
            $result = 'You nothing input';
        } elseif (str_starts_with($string, 'http')) {
            $result = $this->getUrlCode($string);
        } else {
            $result = $this->getUrl($string);
        }
        return $result;
    }
}