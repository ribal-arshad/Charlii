<?php

namespace App\Interfaces;

interface SeriesRepositoryInterface
{
    public function getAllSeries();

    public function getSeriesById($seriesId);

    public function createSeries($seriesDetails);

    public function updateSeries($seriesId, $seriesDetails);

    public function changeStatus($seriesId);

    public function deleteSeries($seriesId);
}
