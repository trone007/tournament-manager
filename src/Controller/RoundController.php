<?php
namespace Src\Controller;

use Core\Controller;
use Core\SessionHelper;
use Doctrine\ORM\EntityManagerInterface;
use Src\Exceptions\WrongCredentialsException;
use Src\Service\CredentialsServiceInterface;
use Src\Service\TeamService;
use Src\Service\TeamServiceInterface;
use Src\Service\UserServiceInterface;
use Twig\Environment;

class RoundController extends Controller
{
    /**
     * @var TeamService
     */
    private $tournamentService;
    /**
     * UserController constructor.
     * @param Environment $twig
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        Environment $twig,
        EntityManagerInterface $entityManager,
        TeamServiceInterface $teamService
    )
    {
        parent::__construct($twig, $entityManager);
        $this->teamService = $teamService;
    }

    public function getTeamList()
    {
        $this->renderJson($this->teamService->getAllTeams());
    }

}