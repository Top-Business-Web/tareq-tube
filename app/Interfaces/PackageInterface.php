<?php

namespace App\Interfaces;

Interface PackageInterface {

    public function index($request);
    
    public function showCreate();
    
    public function storePackage($request);
    
    public function showEditPage($id);
    
    public function updatePackage( $request, $id);
    
    public function deletePackage($request);

}