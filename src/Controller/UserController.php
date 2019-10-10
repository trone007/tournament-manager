<?php
namespace Src\Controller;

use Core\Controller;
use Core\SessionHelper;
use Doctrine\ORM\EntityManagerInterface;
use Src\Exceptions\WrongCredentialsException;
use Src\Service\User\CredentialsServiceInterface;
use Src\Service\User\UserServiceInterface;
use Twig\Environment;

class UserController extends Controller
{
    private $userService;
    private $credentialsService;

    /**
     * UserController constructor.
     * @param Environment $twig
     * @param EntityManagerInterface $entityManager
     * @param UserServiceInterface $userService
     * @param CredentialsServiceInterface $credentialsService
     */
    public function __construct(
        Environment $twig,
        EntityManagerInterface $entityManager,
        UserServiceInterface $userService,
        CredentialsServiceInterface $credentialsService
    )
    {
        parent::__construct($twig, $entityManager);
        $this->userService = $userService;
        $this->credentialsService = $credentialsService;
    }

    public function index()
    {
        $this->render('login');
    }

    /**
     * login page controller
     */
    public function login()
    {
        $credentialKey = CredentialsServiceInterface::WRONG_CREDENTIALS_KEY;
        if($this->request->isPost()) {

            try {
                $username = $this->request->postParameter('username', '');
                $password = $this->request->postParameter('password', '');

                $this->userService->authenticate($username, $password);
                $this->redirect('/');
            } catch (WrongCredentialsException $e) {
                SessionHelper::set($credentialKey, true);
            }
        }

        $this->render('login');
        /**
         * @todo make flash messages
         */
        if(SessionHelper::get($credentialKey)) {
            SessionHelper::remove($credentialKey);
        }
    }

    /**
     * logout point
     */
    public function logout()
    {
        $this->credentialsService->eraseCredentials();
        $this->redirect('/');
    }

    public function isAuthenticated()
    {
        $this->renderJson($this->credentialsService->hasCredentials());
    }
}