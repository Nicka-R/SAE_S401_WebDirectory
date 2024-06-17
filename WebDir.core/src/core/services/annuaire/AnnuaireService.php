<?php
namespace web\directory\core\services\annuaire;

use web\directory\core\domain\entities as Entities;
use web\directory\core\services\annuaire\AnnuaireServiceInterface;
use web\directory\core\services\exceptions\AnnuaireException;

class AnnuaireService implements AnnuaireServiceInterface
{
    /**
     * 
     */
    public function getServices(): array
    {
        try {
            $services = Entities\Service::all();
            return $services->toArray();
        } catch (\Exception $e) {
            throw new AnnuaireException('Erreur lors de la récupération des services');
        }
    }

    /**
     * 
     */
    public function getDepartements(): array
    {
        try {
            $departements = Entities\Departement::all();
            return $departements->toArray();
        } catch (\Exception $e) {
            throw new AnnuaireException('Erreur lors de la récupération des départements');
        }
    }



    public function createDepartement(array $values)
    {

        if (isset($values['libelle']) && isset($values['description'])) {
            $new_dept = new Entities\Departement();

            if (isset($values['libelle']) && isset($values['description']) && isset($values['etage']))
            {
                $new_dept->libelle = $values['libelle'];
                $new_dept->description = $values['description'];
                $new_dept->etage = $values['etage'];
                $new_dept->save();
            }

        }
    }


    public function createService(array $values)
    {
        if (isset($values['libelle']) && isset($values['description'])) {
            
            $new_service = new Entities\Service();

            if (isset($values['libelle']) && isset($values['description']))
            {
                $new_service->libelle = $values['libelle'];
                $new_service->description = $values['description'];
                $new_service->save();
            }

        }
    }


    public function displayEntree()
    {
        $res = [];

        $personnes= Entities\Personne::all();

        foreach($personnes as $personne)
       

        return $res;
    }

}