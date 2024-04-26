<?php

namespace App\Interfaces;

use PhpParser\Builder\Interface_;

Interface CouponRepositoryInterface
{
    public function getDataTable();
    public function createId($request);
    public function updateRole($id);
    public function delete($id);
    public function changeStatus($id);
    public function getId($id);
}

