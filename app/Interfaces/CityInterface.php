<?php

namespace App\Interfaces;

Interface CityInterface {

    public function index($request);
    
    public function showCreate();
    
    public function storeCity($request);
    
    public function showEditCity($id);
    
    public function updateCity( $request, $id);
    
    public function deleteCity($request);

}