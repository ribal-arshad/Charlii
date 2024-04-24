<?php

namespace App\Interfaces;

interface ColorRepositoryInterface
{
    public function getAllColors();

    public function getColorById($colorId);

    public function createColor($colorDetails);

    public function updateColor($colorId, $colorDetails);

    public function changeStatus($colorId);

    public function deleteColor($colorId);
}
