<?php


namespace web\directory\core\services\userDataHarvestService;

use web\directory\core\domain\entities as Entities;


class UserDataHarvestService implements UserDataHarvestInterface{

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

     /**
     * 
     */
    public function getFonctions():array{

        $fonctions = Entities\Fonction::all();

        return $fonctions->toArray();

    }

}