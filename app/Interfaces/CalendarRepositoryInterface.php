<?php

namespace App\Interfaces;

interface CalendarRepositoryInterface
{
    public function getAllCalendars();

    public function getCalendarById($calendarId);

    public function createCalendar($calendarDetails);

    public function updateCalendar($calendarId, $calendarDetails);

    public function deleteCalendar($calendarId);
}
