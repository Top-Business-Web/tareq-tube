<?php

namespace App\Interfaces;

Interface ConfigCountInterface {

    public function index($request);
    
    public function showCreate();
    
    public function storeConfigCount($request);
    
    public function showEditConfigCount($id);
    
    public function updateConfigCount( $request, $id);
    
    public function deleteConfigCount($request);

}