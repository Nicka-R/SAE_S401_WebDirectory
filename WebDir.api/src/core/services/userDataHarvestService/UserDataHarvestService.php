<?php


namespace web\directory\api\core\services\userDataHarvestService;

use web\directory\api\core\domain\entities as Entities;
use web\directory\api\core\services\userDataHarvestService\UserDataHarvestInterface;


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

}