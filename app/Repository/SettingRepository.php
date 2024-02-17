<?php

namespace App\Repository;

use App\Interfaces\SettingInterface;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingRepository implements SettingInterface
{

    public function showEditSetting(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $setting = Setting::first();

        $settingData = $setting->only(['id', 'logo', 'phone', 'limit_user', 'point_user', 'vat', 'privacy', 'point_price', 'token_price', 'limit_balance']);

        return view('admin/settings/index', compact('settingData'));
    }

    public function updateSetting($request)
    {
        $id = $request->id;
        try {
            $setting = Setting::findOrFail($id);

            $inputs = $request->except('id');

            $this->uploadImage($request, $admin);

            $setting->update($inputs);

            toastr()->addSuccess('تم التعديل الاعدادات بنجاح');
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }
        return redirect()->route('setting.index')->send();

    }


    private function uploadImage($request, &$inputs)
    {
        if ($request->hasFile('logo')) {
            $imagePath = $request->file('image')->store('uploads/setting', 'public');
            $inputs['logo'] = $imagePath;
        } else {
            unset($inputs['logo']);
        }
    }
}
