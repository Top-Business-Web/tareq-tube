<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\MessageInterface;
use Illuminate\Http\Request;

class MsgController extends Controller
{
    private MessageInterface $messageInterface;

    public function __construct(MessageInterface $messageInterface)
    {
        $this->messageInterface = $messageInterface;
    }

    public function index(Request $request)
    {
        return $this->messageInterface->index($request);
    }

    public function deleteMessage(Request $request)
    {
        return $this->messageInterface->deleteMessage($request);
    }
}
