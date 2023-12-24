<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\SliderInterface;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    private SliderInterface $sliderInterface;

    public function __construct(SliderInterface $sliderInterface)
    {
        $this->sliderInterface = $sliderInterface;
    }

    public function index(Request $request)
    {
        return $this->sliderInterface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->sliderInterface->showCreate($request);
    }

    public function storeSlider(Request $request)
    {
        return $this->sliderInterface->storeSlider($request);
    }

    public function showEditSlider($id)
    {
        return $this->sliderInterface->showEditSlider($id);
    }

    public function updateSlider(Request $request, $id)
    {
        return $this->sliderInterface->updateSlider($request, $id);
    }

    public function deleteSlider(Request $request)
    {
        return $this->sliderInterface->deleteSlider($request);
    }
}
