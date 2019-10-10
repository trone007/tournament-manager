<?php
namespace Src\Service\User;

use Core\SessionHelper;
use Src\Model\User;

class CredentialsService implements CredentialsServiceInterface
{
    const AUTHENTICATED_KEY = 'authenticated';
    const ROLE_KEY = 'role';
    const USER_KEY = 'user';

    /**
     * add credentials to authorized user
     * @param User $user
     */
    public function addCredentials(User $user): void
    {
        SessionHelper::set(self::AUTHENTICATED_KEY, true);
        SessionHelper::set(self::ROLE_KEY, 'role_admin');
        SessionHelper::set(self::USER_KEY, [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'created_at' => $user->getCreatedAt(),
        ]);
    }

    /**
     * remove credentials from user
     * actually using before/after logout
     */
    public function eraseCredentials(): void
    {
        SessionHelper::stop();
    }

    /**
     * check user credentials to use services
     * @return bool
     */
    public static function hasCredentials(): bool
    {
        if(SessionHelper::get(self::AUTHENTICATED_KEY) && SessionHelper::get(self::ROLE_KEY)) {
            return true;
        }

        return false;
    }
}