<?php
namespace EA\Domain\Services;

interface SendSms
{
    public function sendSms($o, $message);
}
