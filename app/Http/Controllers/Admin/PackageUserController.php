<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\PackageUserInterface;
use Illuminate\Http\Request;

class PackageUserController extends Controller
{
    private PackageUserInterface $packageUserInterface;

    public function __construct(PackageUserInterface $packageUserInterface)
    {
        $this->packageUserInterface = $packageUserInterface;
    }

    public function index(Request $request)
    {
        return $this->packageUserInterface->index($request);
    }

    public function deletePackageUser(Request $request)
    {
        return $this->packageUserInterface->deletePackageUser($request);
    }
}
