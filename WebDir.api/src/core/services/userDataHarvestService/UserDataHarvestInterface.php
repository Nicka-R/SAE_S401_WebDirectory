<?php

namespace web\directory\api\core\services\userDataHarvestService;

interface UserDataHarvestInterface{

    public function getEntrees():array;

    public function getDepartement(string $id):array;
    
}