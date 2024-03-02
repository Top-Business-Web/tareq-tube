<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\YoutubeKeyInterface;

class YoutubeKeyController extends Controller
{
    private YoutubeKeyInterface $interface;

    public function __construct(YoutubeKeyInterface $interface)
    {
        $this->interface = $interface;
    }

    public function index(Request $request)
    {
        return $this->interface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->interface->showCreate($request);
    }

    public function storeKey(Request $request)
    {
        return $this->interface->storeKey($request);
    }

    public function deleteKey(Request $request)
    {
        return $this->interface->deleteKey($request);
    }
}
