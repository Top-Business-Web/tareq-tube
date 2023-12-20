<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Interfaces\AdminInterface;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    private AdminInterface $adminInterface;

    public function __construct(AdminInterface $adminInterface)
    {
        $this->adminInterface = $adminInterface;
    }

    public function index(Request $request)
    {
        return $this->adminInterface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->adminInterface->showCreate($request);
    }

    public function delete(Request $request)
    {
        return $this->adminInterface->delete($request);
    }

    public function myProfile()
    {
        return $this->adminInterface->myProfile();
    }

    public function create()
    {
        return $this->adminInterface->create();
    }

    public function storeAdmin(AdminRequest $request)
    {
        return $this->adminInterface->storeAdmin($request);
    }

    public function showEdit($id)
    {
        return $this->adminInterface->showEdit($id);
    }

    public function updateAdmin(AdminRequest $request, $id)
    {
        return $this->adminInterface->updateAdmin($request, $id);
    }
}//end class
