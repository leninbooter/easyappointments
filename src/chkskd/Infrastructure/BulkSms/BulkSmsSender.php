<?php
namespace EA\Infrastructure\BulkSms;

use EA\Domain\Services\SendSms;
use EA\Engine\Api\V1\Exception;
use EA\Infrastructure\OAuthClient\OAuthClient;

class BulkSmsSender extends OAuthClient implements SendSms
{
    const BULKSMS_POST_URL = 'https://api.bulksms.com/v1/messages';

    function __construct($authToken)
    {
        $this->token = base64_encode($authToken);
    }

    public function sendSms($to, $message)
    {
        if(strlen($message) >= 150) {
            throw new Exception('Message for SMS too long');
        }

        $payload = array('to' => $to, 'body' => $message);
        $payload = json_encode($payload);
        $this->doPostRequest($payload);
    }
}
