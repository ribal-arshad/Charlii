<?php

namespace App\Interfaces;

interface PackageRepositoryInterface
{
    public function getDataTable();

    public function createId($request);
    public function getid($id);
    public function delete($id);
    public function changeStatus($id);

}
