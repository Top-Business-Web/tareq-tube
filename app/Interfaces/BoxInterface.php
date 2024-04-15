<?php

namespace App\Interfaces;

Interface BoxInterface {

    public function index($request);

    public function showCreate();

    public function storeBox($request);

    public function showEditBox($id);

    public function updateBox( $request, $id);

    public function deleteBox($request);

}
