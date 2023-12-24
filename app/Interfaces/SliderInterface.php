<?php

namespace App\Interfaces;

Interface SliderInterface {

    public function index($request);
    
    public function showCreate();
    
    public function storeSlider($request);
    
    public function showEditSlider($id);
    
    public function updateSlider( $request, $id);
    
    public function deleteSlider($request);

}