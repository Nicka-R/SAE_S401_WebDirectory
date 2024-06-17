<?php


namespace web\directory\core\services\UserDataService;

use web\directory\core\domain\entities as Entities;


class UserDataService implements UserDataHarbestInterface{

    /**
     * 
     */
    public function getServices():array{
        
        $services = Entities\Service::all();

        return $services->toArray();

    }

    /**
     * 
     */
    public function getDepartements():array{

        $departement = Entities\Departement::all();

        return $departement->toArray();

    }

}