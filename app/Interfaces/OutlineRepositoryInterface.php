<?php

namespace App\Interfaces;

interface OutlineRepositoryInterface
{
    public function getAllOutlines();

    public function getOutlineById($outlineId);

    public function createOutline($outlineDetails);

    public function updateOutline($outlineId, $outlineDetails);

    public function changeStatus($outlineId);

    public function deleteOutline($outlineId);
}
