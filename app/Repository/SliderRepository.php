<?php

namespace App\Repository;

use App\Interfaces\SliderInterface;
use App\Models\Slider;
use Yajra\DataTables\DataTables;

class SliderRepository implements SliderInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $sliders = Slider::get();
            return DataTables::of($sliders)
                ->addColumn('action', function ($sliders) {
                    return '
                            <a href="' . route('slider.edit', $sliders->id) . '" class="btn btn-pill btn-info-light"><i class="fa fa-edit"></i></a>
                            <a href="' . route('slider.delete', $sliders->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->editColumn('image', function ($sliders) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . asset('storage/'.$sliders->image) . '">
                    ';
                })
                ->editColumn('url', function ($sliders) {
                    return '<a href="' . $sliders->url . '" target="_blank" style="background-color: #007bff; color: #fff; padding: 5px; cursor: pointer; text-decoration: none; border: 1px solid #007bff; border-radius: 5px;">' . $sliders->url . '</a>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/sliders/index');
        }
    }

    public function showCreate()
    {
        return view('admin/sliders/parts/create');
    }

    public function storeSlider($request)
    {
        try {
            $inputs = $request->all();

            $this->uploadImage($request, $inputs);

            if ($this->createSlider($inputs)) {
                toastr()->addSuccess('تم اضافة الصورة المتحركة بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function uploadImage($request, &$inputs)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/sliders', 'public');
            $inputs['image'] = $imagePath;
        } else {
            unset($inputs['image']);
        }
    }

    private function createSlider($inputs)
    {
        return Slider::create($inputs);
    }

    public function showEditSlider($id)
    {
        $slider = Slider::findOrFail($id);

        $sliderData = $slider->only(['id', 'image', 'url']);

        return view('admin/sliders/parts/edit', compact('sliderData'));
    }

    public function updateSlider($request, $id)
    {
        try {
            $slider = Slider::findOrFail($id);

            $inputs = $request->except('id');

            $this->uploadImage($request, $inputs);

            $slider->update($inputs);

            toastr()->addSuccess('تم التعديل الصورة المتحركة بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteSlider($request)
    {
        $slider = Slider::findOrFail($request->id);

            $slider->delete();
            toastr()->addSuccess("تم حذف الصورة المتحركة بنجاح");
            return redirect()->back();
    }

}