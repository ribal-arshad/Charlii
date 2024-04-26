<?php

namespace App\Interfaces;

interface TimelineEventTypesRepositoryInterface
{
    public function getAllEventTypes();

    public function getEventTypeById($eventTypeId);

    public function createEventType($eventTypeDetails);

    public function updateEventType($eventTypeId, $eventTypeDetails);

    public function changeStatus($eventTypeId);

    public function deleteEventType($eventTypeId);
}
