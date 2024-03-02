<?php

namespace App\Interfaces;

Interface YoutubeKeyInterface {

    public function index($request);

    public function showCreate();

    public function storeKey($request);

    public function deleteKey($request);

}
