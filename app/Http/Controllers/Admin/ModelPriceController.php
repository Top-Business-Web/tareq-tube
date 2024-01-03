<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ModelPriceInterface;
use Illuminate\Http\Request;

class ModelPriceController extends Controller
{
    private ModelPriceInterface $modelPriceInterface;

    public function __construct(ModelPriceInterface $modelPriceInterface)
    {
        $this->modelPriceInterface = $modelPriceInterface;
    }

    public function index(Request $request)
    {
        return $this->modelPriceInterface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->modelPriceInterface->showCreate($request);
    }

    public function storeModelPrice(Request $request)
    {
        return $this->modelPriceInterface->storeModelPrice($request);
    }

    public function showEditModelPrice($id)
    {
        return $this->modelPriceInterface->showEditModelPrice($id);
    }

    public function updateModelPrice(Request $request, $id)
    {
        return $this->modelPriceInterface->updateModelPrice($request, $id);
    }

    public function deleteModelPrice(Request $request)
    {
        return $this->modelPriceInterface->deleteModelPrice($request);
    }
}
