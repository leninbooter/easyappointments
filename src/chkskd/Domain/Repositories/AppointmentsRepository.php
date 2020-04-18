<?php

namespace EA\Domain\Repositories;

interface AppointmentsRepository
{
    public function findAppointmentsThatStartInMinutes($minutes);
}
