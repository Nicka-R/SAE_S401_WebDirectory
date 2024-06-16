<?php
namespace web\directory\api\core\services\annuaire;
use web\directory\api\core\services\annuaire\AnnuaireServiceInterface;
use web\directory\api\core\services\exceptions\AnnuaireException;
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

    public function getEntreesByService(string $id):array{
        try{
            $personnes = Entities\Personne::whereHas('fonction', function ($query) use ($id) {
                $query->where('id_service', $id);
            })->get();
            return $personnes->toArray();
        }catch(\Exception $e){
            throw new AnnuaireException('Erreur lors de la récupération des personnes');
        }
    }
}