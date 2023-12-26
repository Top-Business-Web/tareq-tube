<?php

namespace App\Interfaces;

Interface AdminInterface {

    public function index($request);

    public function delete($request);
    public function myProfile();

    public function create();
    
    public function showCreate();

    public function storeAdmin($request);

    public function showEdit($id);

    public function updateAdmin( $request, $id);

}
