<?php

namespace web\directory\core\services;

use web\directory\core\domain\entities\Personne;

class   AdministratorManagerService implements AdministratorManagerInterface{

    public function getPersonne(): array
    {
            $categories = Personne::all();
            return $categories->toArray();  
    }
}