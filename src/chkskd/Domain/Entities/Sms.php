<?php
namespace EA\Domain\Entities;

class Sms
{
    protected $to;
    protected $message;

    function __construct($to, $message)
    {
        $this->message = $message;
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}
