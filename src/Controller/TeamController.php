<?php
namespace Src\Controller;

use Core\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Src\Assembler\TeamResourceAssembler;
use Src\Service\TeamServiceInterface;
use Twig\Environment;

class TeamController extends Controller
{
    /**
     * @var TeamServiceInterface
     */
    private $teamService;
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

    public function teamsStatistics()
    {
        $this->render('statistic', ['statistics' => $this->teamService->calculateTeamStatistics()]);
    }

    public function getTeamList()
    {
        $this->renderJson(TeamResourceAssembler::toResources($this->teamService->getAllTeams()));
    }

    public function getAvailableList()
    {
        $roundId = $this->request->getParameter("roundId");
        $tournamentId = $this->request->getParameter("tournamentId");

        $this->renderJson($this->teamService->getAvailableTeam($tournamentId,$roundId));
    }

}