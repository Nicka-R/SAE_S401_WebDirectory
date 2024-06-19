<?php

namespace web\directory\core\services\userDataManagementService;
use  web\directory\core\services\userDataManagementService\UserDataManagementException;
use web\directory\core\domain\entities as Entities;

class UserDataManagementService implements UserDataManagementInterface
{

    /**
     * méthode addPerson : permet d'ajouter une personne
     */
    public function addPerson(array $values)
    {
        try{
            //Màj de la personne
            $new_person = new Entities\Personne();

            if (isset($values['nom']) && isset($values['prenom']) && isset($values['mail'])) {
                $new_person->nom = $values['nom'];
                $new_person->prenom = $values['prenom'];
                $new_person->mail = $values['mail'];
                $new_person->num_bureau = $values['num_bureau'] ?? '';
                $new_person->statut = 0;
                $new_person->save();

                //Màj des numéros moobile/fixe
                if (isset($values['numero_mobile'])) {

                    $new_numero = new Entities\Numero();
                    $new_numero->numero = $values['numero_mobile'];
                    $new_numero->id_perso = $new_person->id;
                    $new_numero->libelle = 'Mobile';
                    $new_numero->save();
 
                    if (isset($values['numero_fixe']) && $values['numero_fixe']!='') { //
                        $new_numero = new Entities\Numero();
                        $new_numero->numero = $values['numero_fixe'];
                        $new_numero->id_perso = $new_person->id;
                        $new_numero->libelle = 'Fixe';
                        $new_numero->save();

                    }
                }

                //Màj des départements
                if (isset($values['departements'])) {
                    $new_person->departement()->attach($values['departements']);
                }
                


                //Màj des services
                if (isset($values['services']))
                    $new_person->service()->attach($values['services']);

                $new_person->save();
            }
        }catch(\Exception $e){
            throw new UserDataManagementException("Erreur lors de l'ajout de la personne");
        }
        
    }
}