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
    public function getEntrees(string $order = null):array{
        try{
            $query = Entities\Personne::query();

            // Gestion du tri
            if ($order !== null) {
                list($champ, $sortOrder) = explode('-', $order);
                if (in_array($champ, ['nom', 'prenom']) && in_array($sortOrder, ['asc', 'desc'])) {
                    $query = $query->orderBy($champ, $sortOrder);
                } else {
                    throw new UserDataException("Paramètre de tri invalide");
                }
            }

            $entrees = $query->get();
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
            
            $personnes = Entities\Personne::whereHas('service', function ($query) use ($id) {
                $query->where('id_service', $id);
            })->get();
    
            return $personnes->toArray();
        }catch(\Exception $e){
            throw new UserDataException('Erreur lors de la récupération des personnes');
        }
    }

    public function getEntreesByNom(string $nom):array{
        try{
            $personnes = Entities\Personne::where('nom', 'like', '%'.$nom.'%')->get();
            if($personnes){
                return $personnes->toArray();
            }
            return [];
        }catch(\Exception $e){
            throw new UserDataException('Erreur lors de la récupération des personnes');
        }
    }

    public function getEntreesByCritere(string $critere, string $valeur): array {
        try {
            // Liste des critères valides
            $validCriteres = ['nom', 'prenom', 'num_bureau', 'mail'];

            if (!in_array($critere, $validCriteres)) {
                throw new UserDataException("Critère de recherche invalide");
            }
    
            $personnes = Entities\Personne::where($critere, 'like', '%' . $valeur . '%')->get();
    
            return $personnes->toArray();
        } catch (UserDataException $e) {
            throw new UserDataException($e->getMessage());
        }catch(\Exception $e){
            throw new \Exception('Erreur lors de la récupération des personnes');
        }
    }

    public function getPersonnesService(string $id):array{
        try{
            $services = Entities\Personne::find($id)->service;
            if(empty($services)){
                return [];
            }
            return $services->toArray();
        }catch(\Exception $e){
            throw new UserDataException('Erreur lors de la récupération des personnes');
        }
    }

    public function getPersonnesNumero(string $id):array{
        try{
            //numero de téléphone
            $numeros = Entities\Personne::find($id)->numero;
            return $numeros->toArray();
        }catch(\Exception $e){
            throw new UserDataException('Erreur lors de la récupération des personnes');
        }
    }


}