<?php

namespace App\Coder;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

class UrlValidator
{

    /**
     * @param ClientInterface $client
     */
    public function __construct(
        protected ClientInterface $client
    )
    {}

    /**
     * @param string $url
     * @return bool
     */
    public function isUrl(string $url): bool
    {
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Url is not valid');
        }
        return true;
    }

    /**
     * @param string $url
     * @return bool
     * @throws GuzzleException
     */
    public function isWorking(string $url): bool
    {
        $allowCodes = [
            200, 201, 301, 302
        ];

        try {
            $response = $this->client->request('GET', $url);
            return (!empty($response->getStatusCode()) && in_array($response->getStatusCode(), $allowCodes));
        } catch (ConnectException $e) {
            throw new \Exception('Url ' . $url . ' was not have working connection');
        }
    }
}