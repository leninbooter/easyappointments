<?php
namespace EA\Infrastructure;

class OAuthClient
{
    const TYPE_TOKEN_BEARER = 'Bearer';
    const TYPE_TOKEN_BASIC = 'Basic';

    protected $token;
    protected $tokenType = self::TYPE_TOKEN_BASIC;

    protected function doPostRequest($body)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::BULKSMS_POST_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            sprintf('Authorization: %s %s', $this->tokenType, $this->token),
            'content-type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        // $output contains the output string
        $output = curl_exec($ch);

        // extract header
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($body, 0, $headerSize);

        // extract body
        $body = substr($body, $headerSize);

        curl_close($ch);

        return $body;
    }

    protected function useBearerToken()
    {
        $this->tokenType = self::TYPE_TOKEN_BEARER;
    }
}
