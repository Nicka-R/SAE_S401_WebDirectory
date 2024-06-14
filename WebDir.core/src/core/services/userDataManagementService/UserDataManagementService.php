<?php

namespace web\directory\core\services\userDataManagementService;

use web\directory\core\domain\entities as Entities;

class UserDataManagementService implements UserDataManagementInterface{

    public function addPerson(array $values){

        $new_person = new Entities\Personne();

        $new_person->nom=$values['nom'];
        $new_person->nom=$values['prenom'];


    }
    
}