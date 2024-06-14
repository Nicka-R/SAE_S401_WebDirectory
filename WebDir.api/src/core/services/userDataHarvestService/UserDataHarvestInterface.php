<?php

namespace web\directory\api\core\services\userDataHarvestService;

interface UserDataHarvestInterface{

    public function getServices():array;

    public function getDepartements():array;
    
}