<?php

namespace App\Repository;

use App\Interfaces\SettingInterface;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingRepository implements SettingInterface
{

    public function showEditSetting()
    {
        $setting = Setting::first();

        $settingData = $setting->only(['id', 'logo', 'phone', 'limit_user', 'point_user', 'vat', 'privacy', 'point_price', 'token_price']);

        return view('admin/settings/index', compact('settingData'));
    }

    public function updateSetting($request, $id)
    {
        try {
            $setting = Setting::findOrFail($id);

            $inputs = $request->except('id');

            $this->uploadImage($request, $admin);

            $setting->update($inputs);

            toastr()->addSuccess('تم التعديل الاعدادات بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }
        return redirect()->back();
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