<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\TubeInterface;
use Illuminate\Http\Request;

class TubeController extends Controller
{
    private TubeInterface $tubeInterface;

    public function __construct(TubeInterface $tubeInterface)
    {
        $this->tubeInterface = $tubeInterface;
    }
    public function index(Request $request)
    {
        return $this->tubeInterface->index($request);
    }

    public function deleteTube(Request $request)
    {
        return $this->tubeInterface->deleteTube($request);
    }
}
