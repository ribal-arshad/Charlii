<?php

namespace App\Interfaces;

interface UserGalleryRepositoryInterface
{
    public function getAllImages();

    public function getImageById($imageId);

    public function createImage($imageDetails);

    public function updateImage($imageId, $imageDetails);

    public function changeStatus($imageId);

    public function deleteImage($imageId);
}
