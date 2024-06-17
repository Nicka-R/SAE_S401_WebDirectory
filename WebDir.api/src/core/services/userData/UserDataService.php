<?php


namespace web\directory\api\core\services\userData;

use web\directory\api\core\domain\entities as Entities;
use web\directory\api\core\services\userData\UserDataInterface;
use web\directory\api\core\services\userData\UserDataException;


class UserDataService implements UserDataInterface{

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