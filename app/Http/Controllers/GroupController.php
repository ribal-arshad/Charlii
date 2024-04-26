<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Interfaces\GroupRepositoryInterface;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    private GroupRepositoryInterface $groupRepository;

    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->groupRepository->getDataTable();
        }

        return view('group.index');
    }

    public function addGroup()
    {
        $users = User::where('status', 1)->get();

        return view('group.add', compact( 'users'));
    }

    public function addGroupData(GroupStoreRequest $request)
    {
        return $this->groupRepository->createGroup($request);
    }

    public function updateGroup($groupId)
    {
        $group = Group::findorfail($groupId);

        if (!empty($group)) {
            $users = User::where('status', 1)->get();
            $selectedMembers = $group->members->pluck('id')->toArray();

            return view('group.update', compact('selectedMembers', 'users', 'group'));
        }

        abort(404);
    }

    public function updateGroupData($groupId, GroupUpdateRequest $request)
    {
        return $this->groupRepository->updateGroup($groupId, $request);
    }

    public function getGroupDetail($groupId)
    {
        $group = $this->groupRepository->getGroupById($groupId);

        return view('group.detail', compact('group'));
    }

    public function deleteGroup($groupId)
    {
        return $this->groupRepository->deleteGroup($groupId);
    }
}
