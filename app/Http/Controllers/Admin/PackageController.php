<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\Interfaces\PackageInterface;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    private PackageInterface $packageInterface;

    public function __construct(PackageInterface $packageInterface)
    {
        $this->packageInterface = $packageInterface;
    }

    public function index(Request $request)
    {
        return $this->packageInterface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->packageInterface->showCreate($request);
    }

    public function storePackage(PackageStoreRequest $request)
    {
        return $this->packageInterface->storePackage($request);
    }

    public function showEditPage($id)
    {
        return $this->packageInterface->showEditPage($id);
    }

    public function updatePackage(PackageUpdateRequest $request, $id)
    {
        return $this->packageInterface->updatePackage($request, $id);
    }

    public function deletePackage(Request $request)
    {
        return $this->packageInterface->deletePackage($request);
    }
}
