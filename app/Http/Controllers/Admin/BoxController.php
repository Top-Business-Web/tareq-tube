<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\BoxInterface;
use App\Interfaces\CityInterface;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    private BoxInterface $boxInterface;

    public function __construct(BoxInterface $boxInterface)
    {
        $this->boxInterface = $boxInterface;
    }

    public function index(Request $request)
    {
        return $this->boxInterface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->boxInterface->showCreate($request);
    }

    public function storeBox(Request $request)
    {
        return $this->boxInterface->storeBox($request);
    }

    public function showEditBox($id)
    {
        return $this->boxInterface->showEditBox($id);
    }

    public function updateBox(Request $request, $id)
    {
        return $this->boxInterface->updateBox($request, $id);
    }

    public function deleteBox(Request $request)
    {
        return $this->boxInterface->deleteBox($request);
    }
}
