<?php

namespace App\Repositories;

use App\Interfaces\GroupRepositoryInterface;
use App\Models\Group;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class GroupRepository implements GroupRepositoryInterface
{
    public function getAllGroups()
    {
        return Group::get();
    }

    public function getGroupById($groupId)
    {
        return Group::findOrFail($groupId);
    }

    public function deleteGroup($groupId)
    {
        $group = $this->getGroupById($groupId);
        if (!empty($group)) {
            $group->delete();

            return redirect()->back()->with('success_msg', 'Group successfully deleted.');
        }

        abort(404);
    }

    public function createGroup($groupDetails)
    {
        $group = Group::create([
            'user_id' => $groupDetails->user_id,
            'group_name' => $groupDetails->group_name,
        ]);
        $group->members()->sync($groupDetails->input('members', []));

        if (!empty($groupDetails->has('group_icon'))) {
            $file = $groupDetails->file('group_icon');

            $imageName = Str::random(10) . now()->format('YmdHis') . Str::random(10) . '.' . $file->getclientoriginalextension();
            $group->addMedia($file)->usingFileName($imageName)->toMediaCollection('group_icons');
        }

        return redirect()->route('manage.groups')->with('success_msg', 'Group successfully added.');
    }

    public function updateGroup($groupId, $groupDetails)
    {
        $group = Group::findOrFail($groupId);

        if(!empty($group)){
            $group->update([
                'user_id' => $groupDetails['user_id'],
                'group_name' => $groupDetails['group_name'],
            ]);

            $group->members()->sync($groupDetails->input('members', []));

            if (!empty($groupDetails->has('group_icon'))) {
                $file = $groupDetails->file('group_icon');
                $group->clearMediaCollection('group_icons');

                $imageName = Str::random(10) . now()->format('YmdHis') . Str::random(10) . '.' . $file->getclientoriginalextension();
                $group->addMedia($file)->usingFileName($imageName)->toMediaCollection('group_icons');
            }

            return redirect()->route('manage.groups')->with('success_msg', 'Group successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Group not found.');
    }

    public function getDataTable(){
        $query = Group::query();

        return Datatables::of($query)
            ->filter(function ($instance) {
                $search = request('search')['value'];
                if (!empty($search)) {
                    $instance->where(function ($query) use ($search) {
                        $query->whereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })->orWhereTime('start_time', '=', $search)
                            ->orWhereTime('end_time', '=', $search)
                            ->orWhereHas('color', function ($query) use ($search) {
                                $query->where('color', 'like', "%{$search}%");
                            });
                    });
                }
            })
            ->editColumn('user_name', function ($obj) {
                return $obj->user ? $obj->user->name : "";
            })
            ->editColumn('members', function ($obj) {
                $labels = [];
                foreach ($obj->members as $member) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $member->name);
                }

                return implode(' ', $labels);
            })
            ->editColumn('group_icon', function ($obj) {
                return '<img src="' . $obj->getFirstMediaUrl('group_icons') . '" width="200" height="200">';
            })
            ->addColumn('action', function ($obj) {
                $buttons = '<div class="btn-group">';
                if(auth()->user()->can('group.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('group.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('group.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('group.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('group.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('group.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
            ->rawColumns(['user_name', 'members', 'action', 'group_icon'])
            ->make(true);
    }
}
