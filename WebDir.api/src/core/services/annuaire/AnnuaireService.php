<?php
namespace web\directory\api\core\services\annuaire;
use web\directory\api\core\services\annuaire\AnnuaireServiceInterface;
use web\directory\api\core\services\annuaire\AnnuaireException;
use web\directory\api\core\domain\entities as Entities;

class AnnuaireService implements AnnuaireServiceInterface{
     /**
     * 
     */
    public function getServices():array{
        try{
            $services = Entities\Service::all();
            return $services->toArray();
        }catch(\Exception $e){
            throw new AnnuaireException('Erreur lors de la récupération des services');
        }
    }

    /**
     * 
     */
    public function getDepartements():array{
        try{
            $departements = Entities\Departement::all();
            return $departements->toArray();
        }catch(\Exception $e){
            throw new AnnuaireException('Erreur lors de la récupération des départements');
        }
    }

}