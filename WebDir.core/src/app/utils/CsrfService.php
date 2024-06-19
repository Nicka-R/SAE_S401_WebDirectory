<?php

namespace web\directory\app\utils;
class CsrfService
{
    /**
     * génère un token csrf
     * @param string|null $id
     * @return string token
     */
    public static function generate(string $id = null): string
    {
        $token = bin2hex(random_bytes(32));
        if ($id !== null) {
            $_SESSION['csrf_tokens'][$id] = $token;
        }
        return $token;
    }

    /**
     * vérifie si le token est valide
     * @param string $id
     * @param string $token
     * @return bool true si le token est valide
     */
    public static function check(string $id, string $token): bool
    {
        if (isset($_SESSION['csrf_tokens'][$id]) && $_SESSION['csrf_tokens'][$id] === $token) {
            unset($_SESSION['csrf_tokens'][$id]);
            return true;
        }
        return false;
    }
}
