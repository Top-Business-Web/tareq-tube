<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\SettingInterface;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private SettingInterface $settingInterface;

    public function __construct(SettingInterface $settingInterface)
    {
        $this->settingInterface = $settingInterface;
    }

    public function showEditSetting()
    {
        return $this->settingInterface->showEditSetting();
    }

    public function updateSetting(Request $request, $id)
    {
        $this->settingInterface->updateSetting($request, $id);
    }
}
