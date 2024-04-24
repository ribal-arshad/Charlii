<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserGalleryStoreRequest;
use App\Http\Requests\UserGalleryUpdateRequest;
use App\Interfaces\UserGalleryRepositoryInterface;
use App\Models\User;
use App\Models\UserGallery;
use Illuminate\Http\Request;

class UserGalleryController extends Controller
{
    private UserGalleryRepositoryInterface $galleryRepository;

    public function __construct(UserGalleryRepositoryInterface $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->galleryRepository->getDataTable();
        }

        return view('user-gallery.index');
    }

    public function addImage()
    {
        $users = User::where('status', 1)->where('id', '!=', 1)->get();

        return view('user-gallery.add', compact('users'));
    }

    public function addImageData(UserGalleryStoreRequest $request)
    {
        return $this->galleryRepository->createImage($request);
    }

    public function updateImage($imageId)
    {
        $users = User::where('status', 1)->where('id', '!=', 1)->get();
        $image = UserGallery::findorfail($imageId);

        if (!empty($image)) {
           return view('user-gallery.update', compact('users', 'image'));
        }

        abort(404);
    }

    public function updateImageData($imageId, UserGalleryUpdateRequest $request)
    {
        return $this->galleryRepository->updateImage($imageId, $request);
    }

    public function getImageDetail($imageId)
    {
        $image = $this->galleryRepository->getImageById($imageId);

        return view('user-gallery.detail', compact('image'));
    }

    public function changeImageStatus($imageId)
    {
        return $this->galleryRepository->changeStatus($imageId);
    }

    public function deleteImage($imageId)
    {
        return $this->galleryRepository->deleteImage($imageId);
    }
}
