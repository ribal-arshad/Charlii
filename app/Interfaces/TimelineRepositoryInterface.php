<?php

namespace App\Interfaces;

interface TimelineRepositoryInterface
{
    public function getAllTimelines();

    public function getTimelineById($timelineId);

    public function createTimeline($timelineDetails);

    public function updateTimeline($timelineId, $timelineDetails);

    public function changeStatus($timelineId);

    public function deleteTimeline($timelineId);
}
