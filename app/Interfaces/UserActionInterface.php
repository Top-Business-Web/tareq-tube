<?php

namespace App\Interfaces;

Interface UserActionInterface {

    public function index($request);
    
    public function deleteUserAction($request);

}