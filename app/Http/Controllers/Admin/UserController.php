<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }
    public function index(Request $request)
    {
        return $this->userInterface->index($request);
    }

    public function delete(Request $request)
    {
        return $this->userInterface->delete($request);
    }

    public function changeStatusUser(Request $request)
    {
        return $this->userInterface->changeStatusUser($request);
    }
}
