<?php

namespace web\directory\core\services\userData;

interface UserDataInterface{

    public function getEntrees():array;

    public function getDepartement(string $id):array;

    public function getEntreesByService(string $id):array;
    
}