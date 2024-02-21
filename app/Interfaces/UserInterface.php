<?php

namespace App\Interfaces;

Interface UserInterface {

    public function index($request);
    public function delete($request);
    public function changeStatusUser($request);
}
