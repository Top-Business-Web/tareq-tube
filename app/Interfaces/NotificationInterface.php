<?php

namespace App\Interfaces;

Interface NotificationInterface {

    public function index($request);
    
    public function showCreate();
    
    public function storeNotification($request);
    
    public function showEditNotification($id);
    
    public function updateNotification($request, $id);
    
    public function deleteNotification($request);

}