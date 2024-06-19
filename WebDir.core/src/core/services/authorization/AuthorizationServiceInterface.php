<?php
namespace web\directory\core\services\authorization;

interface AuthorizationServiceInterface{
    public function isGranted(string $user_id, int $operation): bool;
}