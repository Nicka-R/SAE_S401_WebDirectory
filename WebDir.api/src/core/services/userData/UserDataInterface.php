<?php

namespace web\directory\api\core\services\userData;

interface UserDataInterface{

    public function getEntrees(string $order = null):array;

    public function getDepartement(string $id):array;

    public function getEntreesByService(string $id):array;

    public function getEntreesByNom(string $nom):array;

    public function getEntreesByCritere(string $critere, string $valeur): array;
}