<?php


namespace web\directory\api\core\services\userDataHarvestService;

use web\directory\api\core\domain\entities as Entities;
use web\directory\api\core\services\userDataHarvestService\UserDataHarvestInterface;
use web\directory\api\core\services\exceptions\UserDataException;


class UserDataHarvestService implements UserDataHarvestInterface{

    /**
     * fonction qui retourne les données des personnes
     * @return array
     */
    public function getEntrees():array{
        try{
            $entrees = Entities\Personne::all();
            return $entrees->toArray();
        }catch(\Exception $e){
            throw new UserDataException('Erreur lors de la récupération des personnes');
        }
    }

    /**méthode qui retourne le département d'une personne
     * @param int $id
     * @return array
     */
    public function getDepartement(string $id):array{
        try{
            $departement = Entities\Personne::find($id)->departement;
            return $departement->toArray();
        }catch(\Exception $e){
            throw new UserDataException('Erreur lors de la récupération du département');
        }
    }

    /**
     * fonction qui retourne les données d'une personne en fonction de son id
     * @param string $id
     * @return array
     */
    public function getPersonne(string $id):array{
        try{
            $personne = Entities\Personne::find($id);
            return $personne->toArray();
        }catch(\Exception $e){
            throw new UserDataException('Erreur lors de la récupération de la personne');
        }
    }


}