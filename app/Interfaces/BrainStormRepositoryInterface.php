<?php

namespace App\Interfaces;

interface BrainStormRepositoryInterface
{
    public function getDataTable();
    public function createBrainStorm($request);
    public function getBrainById($brainId);
    public function updateBrain($brainId,$request);
    public function deleteBrain($brainId);
    public function changeStatus($brainId);

}
