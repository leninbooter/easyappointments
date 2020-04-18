<?php


namespace EA\Application\Services\SendAppointmentLink;


use EA\Domain\Repositories\AppointmentsRepository;
use EA\Domain\Services\GetWhoSendAppointmentsLink;

class SendAppointmentLink
{
    /** @var AppointmentsRepository $appointmentsRepository */
    private $appointmentsRepository;

    function __construct($appointmentsRepository)
    {
        $this->appointmentsRepository = $appointmentsRepository;
    }

    public function execute()
    {
        $getWhatAppointmentsLinkSend = new GetWhoSendAppointmentsLink($this->appointmentsRepository);
        $appointments = $getWhatAppointmentsLinkSend->getAppointments();

        foreach ($appointments as $appointment) {
            echo $appointment['start_datetime'] . ' ' . $appointment['hash'];
        }
    }
}
