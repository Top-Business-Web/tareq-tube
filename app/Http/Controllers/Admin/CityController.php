<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CityInterface;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private CityInterface $cityInterface;

    public function __construct(CityInterface $cityInterface)
    {
        $this->cityInterface = $cityInterface;
    }

    public function index(Request $request)
    {
        return $this->cityInterface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->cityInterface->showCreate($request);
    }

    public function storeCity(Request $request)
    {
        return $this->cityInterface->storeCity($request);
    }

    public function showEditCity($id)
    {
        return $this->cityInterface->showEditCity($id);
    }

    public function updateCity(Request $request, $id)
    {
        return $this->cityInterface->updateCity($request, $id);
    }

    public function deleteCity(Request $request)
    {
        return $this->cityInterface->deleteCity($request);
    }
}
