<?php

namespace App\Interfaces;

interface PackageOptionRepositoryInterface
{
    public function getDataTable();
    public function createId($request);
    public function updateRole($id);
    public function delete($id);
}

