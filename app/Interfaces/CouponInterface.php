<?php

namespace App\Interfaces;

Interface CouponInterface {

    public function index($request);
    
    public function showCreate();
    
    public function storeCoupon($request);
    
    public function showEditCoupon($id);
    
    public function updateCoupon( $request, $id);
    
    public function deleteCoupon($request);

}