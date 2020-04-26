<?php


namespace EA\Application\Services\SendAppointmentLink;


use EA\Domain\Entities\Sms;
use EA\Domain\Repositories\AppointmentsRepository;
use EA\Domain\Services\CreateAppointmentLinkNotification;
use EA\Domain\Services\GetWhoSendAppointmentsLink;
use EA\Domain\Services\SendSms;
use EA\Domain\Services\UrlShortener;

class SendAppointmentLink
{
    /** @var AppointmentsRepository $appointmentsRepository */
    private $appointmentsRepository;
    /** @var UrlShortener $urlShortener */
    private $urlShortener;
    /** @var SendSms $smsSender */
    private $smsSender;

    function __construct($appointmentsRepository, $urlShortener, $smsSender)
    {
        $this->appointmentsRepository = $appointmentsRepository;
        $this->urlShortener = $urlShortener;
        $this->smsSender = $smsSender;
    }

    public function execute()
    {
        $getWhatAppointmentsLinkSend = new GetWhoSendAppointmentsLink($this->appointmentsRepository);
        $appointments = $getWhatAppointmentsLinkSend->getAppointments();

        foreach ($appointments as $appointment) {
            $appointmentLinkNotification = new CreateAppointmentLinkNotification($this->urlShortener);
            echo $appointment['start_datetime'] . ' ' . $appointment['hash'];
            /** @var Sms $sms */
            $sms = $appointmentLinkNotification->execute($appointment);
            $this->smsSender->sendSms($sms->getTo(), $sms->getMessage());
        }
    }
}
