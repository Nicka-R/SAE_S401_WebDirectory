<?php
namespace web\directory\core\services\annuaire;

interface AnnuaireServiceInterface {
    
    public function getServices():array;

    public function getDepartements():array;
}