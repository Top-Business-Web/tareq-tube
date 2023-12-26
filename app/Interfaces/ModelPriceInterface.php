<?php

namespace App\Interfaces;

Interface ModelPriceInterface {

    public function index($request);
    
    public function showCreate();
    
    public function storeModelPrice($request);
    
    public function showEditModelPrice($id);
    
    public function updateModelPrice( $request, $id);
    
    public function deleteModelPrice($request);

}