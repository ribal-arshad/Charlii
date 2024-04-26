<?php

namespace App\Interfaces;

interface PlotPlannerRepositoryInterface
{
    public function getAllPlotPlanners();

    public function getPlotPlannerById($plotPlannerId);

    public function createPlotPlanner($plotPlannerDetails);

    public function updatePlotPlanner($plotPlannerId, $plotPlannerDetails);

    public function changeStatus($plotPlannerId);

    public function deletePlotPlanner($plotPlannerId);
}
