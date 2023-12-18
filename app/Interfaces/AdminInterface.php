<?php

namespace App\Interfaces;

Interface AdminInterface {

    public function index($request);

    public function delete($request);
    public function myProfile();

    public function create();

    public function store($request);

    public function edit($admin);

    public function update( $request, $id);

}
