<?php

namespace App\Interfaces;

interface GroupRepositoryInterface
{
    public function getAllGroups();

    public function getGroupById($groupId);

    public function createGroup($groupDetails);

    public function updateGroup($groupId, $groupDetails);

    public function deleteGroup($groupId);
}
