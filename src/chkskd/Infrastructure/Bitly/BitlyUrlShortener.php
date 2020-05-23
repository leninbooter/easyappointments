<?php
namespace EA\Infrastructure\Bitly;

use EA\Domain\Services\UrlShortener;
use EA\Infrastructure\OAuthClient\OAuthClient;

class BitlyUrlShortener extends OAuthClient  implements UrlShortener
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
        $requestResponse = $this->doPostRequest(self::ENDPOINT, $body);
        $response = json_decode($requestResponse, true);
        return $response['link'];
    }
}
