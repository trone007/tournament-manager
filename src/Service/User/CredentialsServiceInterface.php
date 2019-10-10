<?php
namespace Src\Service\User;

use Src\Model\User;

interface CredentialsServiceInterface
{
    const WRONG_CREDENTIALS_KEY = 'wrong_credentials';

    /**
     * add credentials to authorized user
     * @param User $user
     */
    public function addCredentials(User $user): void;

    /**
     * remove credentials from user
     * actually using before/after logout
     */
    public function eraseCredentials(): void;

    /**
     * check user credentials to use services
     * @return bool
     */
    public static function hasCredentials(): bool;
}