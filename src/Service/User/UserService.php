<?php
namespace Src\Service\User;

use Src\Exceptions\WrongCredentialsException;
use Src\Model\User;
use Src\Repository\UserRepository;

class UserService implements UserServiceInterface
{
    private $userRepository;
    private $credentialsService;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param CredentialsServiceInterface $credentialsService
     */
    public function __construct(UserRepository $userRepository, CredentialsServiceInterface $credentialsService)
    {
        $this->userRepository = $userRepository;
        $this->credentialsService = $credentialsService;
    }

    /**
     * @param $username
     * @param $password
     * @throws WrongCredentialsException
     */
    public function authenticate(string $username, string $password): void
    {
        if(empty($username) || empty($password)) {
            throw new WrongCredentialsException();
        }

        /** @var User $user */
        $user = $this->userRepository->findOneBy(['login' => $username]);
        if(
            !$user ||
            ($user && !$user->authenticate($password, get_class($this) . '::checkHash'))
        ) {
                throw new WrongCredentialsException();
        }

        $this->credentialsService->addCredentials($user);
    }

    /**
     * checking hash function for authentication method
     * @param $receivedPassword
     * @param $currentPassword
     * @return bool
     */
    public static function checkHash($receivedPassword, $currentPassword): bool
    {
        return sha1($receivedPassword) == $currentPassword;
    }
}