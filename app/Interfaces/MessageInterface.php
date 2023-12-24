<?php

namespace App\Interfaces;

Interface MessageInterface {

    public function index($request);
    
    public function deleteMessage($request);

}