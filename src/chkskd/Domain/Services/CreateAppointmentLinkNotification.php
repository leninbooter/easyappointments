<?php


namespace EA\Domain\Services;


use EA\Domain\Entities\Sms;

class CreateAppointmentLinkNotification
{
    const APPOINTMENT_LINK_TEMPLATE = '%s/%s#config.disableDeepLinking=true';
    const APPOINTMENT_LINK_MESSAGE = '%s, tu cita con %s hoy a las %s horas aqui %s';

    /** @var UrlShortener $urlShortener */
    private $urlShortener;

    function __construct($urlShortener)
    {
        $this->urlShortener = $urlShortener;
    }

    public function execute($appointment)
    {
        $to = $appointment['user.phone_number'];
        if(strpos($to, '+') === FALSE) {
            $to = sprintf('%s%s', \Config::DEFAULT_PHONE_COUNTRY_CODE, $to);
        }

        $link = sprintf(self::APPOINTMENT_LINK_TEMPLATE, \Config::MEET_SERVER, $appointment['hash']);
        var_dump($link);
        $link = $this->urlShortener->shortUrl($link);
        var_dump($link);
        $message = sprintf(self::APPOINTMENT_LINK_MESSAGE,
            $appointment['customer'],
            $appointment['provider'],
            $appointment['start_datetime'],
            $link);

        return new Sms($to, $message);
    }
}
