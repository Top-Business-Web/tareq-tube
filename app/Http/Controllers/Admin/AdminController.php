<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Interfaces\AdminInterface;
use App\Models\Admin;
use Illuminate\Http\Request;

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

    public function store(AdminRequest $request)
    {
        return $this->adminInterface->store($request);
    }

    public function edit(Admin $admin)
    {
        return $this->adminInterface->edit($admin);
    }

    public function update(AdminRequest $request, $id)
    {
        return $this->adminInterface->update($request, $id);
    }
}//end class
