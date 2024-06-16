<?php
namespace web\directory\api\core\services\annuaire;

interface AnnuaireServiceInterface {
    
    public function getServices():array;

    public function getDepartements():array;
}