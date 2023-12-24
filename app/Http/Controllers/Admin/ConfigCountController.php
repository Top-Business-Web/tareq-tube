<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ConfigCountInterface;
use Illuminate\Http\Request;

class ConfigCountController extends Controller
{
    private ConfigCountInterface $configCountInterface;

    public function __construct(ConfigCountInterface $configCountInterface)
    {
        $this->configCountInterface = $configCountInterface;
    }

    public function index(Request $request)
    {
        return $this->configCountInterface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->configCountInterface->showCreate($request);
    }

    public function storeConfigCount(Request $request)
    {
        return $this->configCountInterface->storeConfigCount($request);
    }

    public function showEditConfigCount($id)
    {
        return $this->configCountInterface->showEditConfigCount($id);
    }

    public function updateConfigCount(Request $request, $id)
    {
        return $this->configCountInterface->updateConfigCount($request, $id);
    }

    public function deleteConfigCount(Request $request)
    {
        return $this->configCountInterface->deleteConfigCount($request);
    }
}
