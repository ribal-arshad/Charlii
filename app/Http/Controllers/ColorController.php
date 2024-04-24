<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorStoreRequest;
use App\Http\Requests\ColorUpdateRequest;
use App\Interfaces\ColorRepositoryInterface;
use App\Models\Color;

class ColorController extends Controller
{
    private ColorRepositoryInterface $colorRepository;

    public function __construct(ColorRepositoryInterface $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    public function index()
    {
        if (\request()->ajax()) {
            return $this->colorRepository->getDataTable();
        }

        return view('color.index');
    }

    public function addColor()
    {
        return view('color.add');
    }

    public function addColorData(ColorStoreRequest $request)
    {
        return $this->colorRepository->createColor($request);
    }

    public function updateColor($colorId)
    {
        $color = Color::findorfail($colorId);

        if (!empty($color)) {
            return view('color.update', compact('color'));
        }

        abort(404);
    }

    public function updateColorData($colorId, ColorUpdateRequest $request)
    {
        return $this->colorRepository->updateColor($colorId, $request);
    }

    public function getColorDetail($colorId)
    {
        $color = $this->colorRepository->getColorById($colorId);

        return view('color.detail', compact('color'));
    }

    public function changeColorStatus($colorId)
    {
        return $this->colorRepository->changeStatus($colorId);
    }

    public function deleteColor($colorId)
    {
        return $this->colorRepository->deleteColor($colorId);
    }
}
