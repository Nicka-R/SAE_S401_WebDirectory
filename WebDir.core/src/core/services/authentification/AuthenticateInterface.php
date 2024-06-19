<?php

namespace web\directory\core\services\authentification;

interface AuthenticateInterface
{
    public function login($values);
    public function register(array $values);
    public function logout();
    public static function isAuthenticate(): bool;


}