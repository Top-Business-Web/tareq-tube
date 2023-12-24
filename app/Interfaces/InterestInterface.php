<?php

namespace App\Interfaces;

Interface InterestInterface {

    public function index($request);
    
    public function showCreate();
    
    public function storeInterest($request);
    
    public function showEditInterest($id);
    
    public function updateInterest( $request, $id);
    
    public function deleteInterest($request);

}