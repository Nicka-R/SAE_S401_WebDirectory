<?php
namespace web\directory\core\services\annuaire;

use web\directory\core\domain\entities as Entities;
use web\directory\core\services\annuaire\AnnuaireServiceInterface;
use web\directory\core\services\annuaire\AnnuaireException;

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

            if (isset($values['libelle']) && isset($values['description']) && isset($values['etage'])) {
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

            if (isset($values['libelle']) && isset($values['description'])) {
                $new_service->libelle = $values['libelle'];
                $new_service->description = $values['description'];
                $new_service->save();
            }

        }
    }


    public function displayEntree($departementId = null, $serviceId = null)
    {
        $res = [];
        $query = Entities\Personne::query()->orderBy('nom');

        if (!is_null($departementId) && $departementId != '') {
            $query->whereHas('departement', function ($query) use ($departementId) {
                $query->where('departement.id', $departementId);
            });
        }

        if (!is_null($serviceId) && $serviceId != '') {
            $query->whereHas('service', function ($query) use ($serviceId) {
                $query->where('service.id', $serviceId);
            });
        }

        $personnes = $query->get();

        foreach ($personnes as $personne) {
            $departements = $personne->departement()->get();
            $services = $personne->service()->get();

            $departements_to_add = [];
            foreach ($departements as $departement) {
                array_push($departements_to_add, $departement);
            }

            $services_to_add = [];
            foreach ($services as $service) {
                array_push($services_to_add, $service);
            }

            array_push($res, [
                'infos' => $personne->toArray(),
                'departements' => $departements_to_add,
                'services' => $services_to_add
            ]);
        }

        return $res;
    }


}