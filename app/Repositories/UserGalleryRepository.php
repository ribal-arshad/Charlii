<?php

namespace App\Repositories;

use App\Interfaces\UserGalleryRepositoryInterface;
use App\Models\UserGallery;
use App\Models\User;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserGalleryRepository implements UserGalleryRepositoryInterface
{
    public function getAllImages()
    {
        return UserGallery::get();
    }

    public function getImageById($imageId)
    {
        return UserGallery::findOrFail($imageId);
    }

    public function deleteImage($imageId)
    {
        $image = $this->getImageById($imageId);
        if (!empty($image)) {
            $image->delete();

            return redirect()->back()->with('success_msg', 'Gallery successfully deleted.');
        }

        abort(404);
    }

    public function createImage($imageDetails)
    {
        $imageName = null;
        if ($imageDetails->hasFile('image')) {
            $file = $imageDetails->file('image');
            $imageName = Str::random(10) . now()->format('YmdHis') . Str::random(10) . '.' . $file->getClientOriginalExtension();

            $userGallery = new UserGallery();
            $userGallery->addMedia($file)->usingFileName($imageName)->toMediaCollection('user_gallery_images');

            $userGallery->fill([
                'user_id' => $imageDetails->user_id,
                'image' => $imageName,
                'status' => $imageDetails->status,
            ])->save();
        }

        return redirect()->route('manage.user.gallery')->with('success_msg', 'Gallery successfully added.');
    }

    public function updateImage($imageId, $imageDetails)
    {
        $image = UserGallery::findOrFail($imageId);

        $imageName = null;
        if (!empty($imageDetails->has('image'))) {
            $file = $imageDetails->file('image');
            $image->clearMediaCollection('user_gallery_images');

            $imageName = Str::random(10) . now()->format('YmdHis') . Str::random(10) . '.' . $file->getclientoriginalextension();
            $image->addMedia($file)->usingFileName($imageName)->toMediaCollection('user_gallery_images');
        }

        if(!empty($image)){
            $image->update([
                'user_id' => $imageDetails->user_id,
                'image' => $imageName,
                'status' => $imageDetails['status'],
            ]);

            return redirect()->route('manage.user.gallery')->with('success_msg', 'Gallery successfully updated.');
        }

        return redirect()->back()->withInput()->with('error_msg', 'Gallery not found.');
    }

    public function getDataTable(){

        $query = UserGallery::get();

        return Datatables::of($query)
            ->filter(function ($instance) {
                $search = request('search')['value'];
                if (!empty($search)) {
                    $instance->where(function($w) use ($search){
                        if(strtolower($search) === "active"){
                            $w->orWhere('status', 1);
                        }elseif(strtolower($search) === "inactive"){
                            $w->orWhere('status', 0);
                        }
                    });
                }
            })
            ->addColumn('user', function ($obj) {
                $user = User::where('id', $obj->id)->first();
                return $user?->name;
            })
            ->editColumn('image', function ($obj) {
                return '<img src="' . $obj->getFirstMediaUrl('user_gallery_images') . '" width="200" height="200">';
            })
            ->editColumn('status', function ($obj) {
                $isChecked = "";
                if($obj->status){
                    $isChecked = "checked";
                }

                if (auth()->user()->can('user.gallery.status.update')) {
                    $switchBtn = '<label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" ' . $isChecked . ' onclick="changeStatus(`' . route('image.change.status', $obj->id) . '`)" />
                                            <span class="switch-toggle-slider">
                                              <span class="switch-on">
                                                <i class="bx bx-check"></i>
                                              </span>
                                              <span class="switch-off">
                                                <i class="bx bx-x"></i>
                                              </span>
                                            </span>
                                        </label>';
                } else {
                    $switchBtn = $obj->status === 1 ? 'Active' : 'Inactive';
                }

                return $switchBtn;
            })
            ->addColumn('action', function ($obj) {
                $buttons = '<div class="btn-group">';
                if(auth()->user()->can('user.gallery.detail')) {
                    $buttons .= '<a class="btn btn-primary btn-sm redirect-btn" href="' . route('user.gallery.detail', $obj->id) . '">Show</a>';
                }
                if(auth()->user()->can('user.gallery.edit')) {
                    $buttons .= '<a class="btn btn-success btn-sm redirect-btn" href="' . route('user.gallery.update', $obj->id) . '">Edit</a>';
                }
                if(auth()->user()->can('user.gallery.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm redirect-btn" href="' . route('user.gallery.delete', $obj->id) . '">Delete</a>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
            ->rawColumns(['user', 'image', 'status', 'action'])->make(true);
    }

    public function changeStatus($imageId)
    {
        $msg = 'Something went wrong.';
        $code = 400;
        $image = $this->getImageById($imageId);

        if (!empty($image)) {
            $image->update([
                'status' => !$image->status
            ]);
            $msg = "Gallery status successfully changed.";
            $code = 200;
        }

        return response()->json(['msg' => $msg], $code);
    }
}
