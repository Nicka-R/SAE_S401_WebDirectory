<?php

namespace web\directory\core\services\userDataHarvestService;

interface UserDataHarvestInterface{

    public function getServices():array;

    public function getDepartements():array;
    
    public function getFonctions():array;
}