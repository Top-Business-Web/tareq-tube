<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserActionInterface;
use Illuminate\Http\Request;

class UserActionController extends Controller
{
    private UserActionInterface $userActionInterface;

    public function __construct(UserActionInterface $userActionInterface)
    {
        $this->userActionInterface = $userActionInterface;
    }

    public function index(Request $request)
    {
        return $this->userActionInterface->index($request);
    }

    public function deleteUserAction(Request $request)
    {
        $this->userActionInterface->deleteUserAction($request);
    }
}
