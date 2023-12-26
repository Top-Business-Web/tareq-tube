<?php

namespace App\Interfaces;

Interface UserInterface {

    public function indexPerson($request);
    public function indexCompany($request);
    public function delete($request);

    public function changeStatusUser($request);
}
