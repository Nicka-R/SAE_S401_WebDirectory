<?php
namespace web\directory\core\services\authorization;

use web\directory\core\services\authorization\AuthorizationServiceInterface;
use web\directory\core\domain\entities as Entities;
use web\directory\core\services\userData\UserDataInterface;
use web\directory\core\services\userData\UserDataException;

class AuthorizationService implements AuthorizationServiceInterface
{
    public function isGranted(string $user_id, int $operation): bool
    {
        if ($operation == 1) {
            return $this->isAdmin($user_id);
        } elseif ($operation == 2) {
            return $this->isSuperAdmin($user_id);
        }
    }

    private function isAdmin(string $user_id): bool
    {
        try {
            $user = Entities\Administrator::find($user_id);
            return $user->role == 1;
        } catch (\Exception $e) {
            throw new UserDataException('Erreur lors de la récupération de l\'utilisateur');
        }
    }

    private function isSuperAdmin(string $user_id): bool
    {
        try {
            $user = Entities\Administrator::find($user_id);
            return $user->role == 100;
        } catch (\Exception $e) {
            throw new UserDataException('Erreur lors de la récupération de l\'utilisateur');
        }
    }
}