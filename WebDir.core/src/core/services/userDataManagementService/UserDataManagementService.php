<?php

namespace web\directory\core\services\userDataManagementService;

use web\directory\core\domain\entities as Entities;

class UserDataManagementService implements UserDataManagementInterface{

    /**
     * méthode addPerson : permet d'ajouter une personne
     */
    public function addPerson(array $values){

        //Màj de la personne
        $new_person = new Entities\Personne();
        $new_person->nom=$values['nom'];
        $new_person->nom=$values['prenom'];
        $new_person->nom=$values['mail'];
        $new_person->num_bureau=$values['num_bureau'] ?? '';
        $new_person->save();

        //Màj des numéros moobile/fixe
        if(isset($values['numero_mobile']))
        {
            $new_numero = new Entities\Numero();
            $new_numero->numero=$values['numero_mobile'];
            $new_numero->id_perso=$new_person->id;
            $new_numero->save();

            if(isset($values['numero_fixe']))
            {
                $new_numero = new Entities\Numero();
                $new_numero->numero=$values['numero_fixe'];
                $new_numero->id_perso=$new_person->id;
                $new_numero->save();
            }
        }

        //Màj des départements
        if (isset($values['departement']))
            $new_person->departement()->attach($values['departement']);

        //Màj des fonctions
        if (isset($values['fonction']))
            $new_person->departement()->attach($values['fonction']);
        
    }
}