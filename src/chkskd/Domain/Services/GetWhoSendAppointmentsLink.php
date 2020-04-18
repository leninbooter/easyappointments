<?php
namespace EA\Domain\Services;

use EA\Domain\Repositories\AppointmentsRepository;

class GetWhoSendAppointmentsLink
{
    const MINUTES_BEFORE_APPT = 5;

    /** @var AppointmentsRepository $appointmentsRepository */
    private $appointmentsRepository;

    function __construct($appointmentsRepository)
    {
        $this->appointmentsRepository = $appointmentsRepository;
    }

    public function getAppointments()
    {
        return $this->appointmentsRepository->findAppointmentsThatStartInMinutes(self::MINUTES_BEFORE_APPT);
    }
}
