<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\InterestInterface;

class InterestController extends Controller
{
    private InterestInterface $interestInterface;

    public function __construct(InterestInterface $interestInterface)
    {
        $this->interestInterface = $interestInterface;
    }

    public function index(Request $request)
    {
        return $this->interestInterface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->interestInterface->showCreate($request);
    }

    public function storeInterest(Request $request)
    {
        return $this->interestInterface->storeInterest($request);
    }

    public function showEditInterest($id)
    {
        return $this->interestInterface->showEditInterest($id);
    }

    public function updateInterest(Request $request, $id)
    {
        return $this->interestInterface->updateInterest($request, $id);
    }

    public function deleteInterest(Request $request)
    {
        return $this->interestInterface->deleteInterest($request);
    }
}
