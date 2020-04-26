<?php


use EA\Infrastructure\OAuthClient;

class BitlyUrlShortener extends OAuthClient  implements \EA\Domain\Services\UrlShortener
{
    const ENDPOINT = 'https://api-ssl.bitly.com/v4/shorten';

    public function __construct($accessToken)
    {
        $this->token = $accessToken;
        $this->useBearerToken();
    }

    public function shortUrl($url)
    {
        $body = array('long_url' =>  $url);
        $body = json_encode($body);
        $requestResponse = $this->doPostRequest($body);
        $response = json_decode($requestResponse, true);
        return $response['link'];
    }
}
