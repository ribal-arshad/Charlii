<?php

namespace App\Interfaces;

interface PremiseRepositoryInterface
{
    public function getAllPremises();

    public function getPremiseById($premiseId);

    public function createPremise($premiseDetails);

    public function updatePremise($premiseId, $premiseDetails);

    public function changeStatus($premiseId);

    public function deletePremise($premiseId);
}
