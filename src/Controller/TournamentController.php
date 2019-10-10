<?php
namespace Src\Controller;

use Core\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Src\Assembler\TournamentBracketResourceAssembler;
use Src\Assembler\TournamentResourceAssembler;
use Src\Service\TournamentServiceInterface;
use Twig\Environment;

class TournamentController extends Controller
{
    /**
     * @var TournamentServiceInterface
     */
    private $tournamentService;

    /**
     * UserController constructor.
     * @param Environment $twig
     * @param EntityManagerInterface $entityManager
     * @param TournamentServiceInterface $tournamentService
     */
    public function __construct(
        Environment $twig,
        EntityManagerInterface $entityManager,
        TournamentServiceInterface $tournamentService
    )
    {
        parent::__construct($twig, $entityManager);
        $this->tournamentService = $tournamentService;
    }

    public function drawGrid()
    {
        $this->render('grid');
    }

    public function getActiveTournament()
    {
        $this->renderJson(
            TournamentResourceAssembler::toResource($this->tournamentService->getActiveTournament())->toArray()
        );
    }

    public function setMatchResult()
    {
        $homeScore = $this->request->postParameter('homeScore');
        $awayScore = $this->request->postParameter('awayScore');
        $gameNumber = $this->request->postParameter('gameNumber');
        $tournamentId = $this->request->postParameter('tournamentId');
        $winnerOption = $this->request->postParameter('winner', "");

        $this->tournamentService->saveScore($tournamentId, $gameNumber, $homeScore, $awayScore, $winnerOption);
    }

    public function setTournamentBracketTeam()
    {
        $tournamentId = $this->request->postParameter('tournamentId');
        $gameNumber = $this->request->postParameter('gameNumber');
        $teamId = $this->request->postParameter('teamId');
        $teamPosition = $this->request->postParameter('teamPosition');

        $this->tournamentService->setTournamentBracketTeam($tournamentId, $gameNumber, $teamId, $teamPosition);
    }

    public function getTournamentBracket()
    {
        $tournamentId = $this->request->getParameter("tournamentId");

        if($tournamentId)
            $this->renderJson(
                TournamentBracketResourceAssembler::toResources(
                    $this->tournamentService->getTournamentBracketByTournament($tournamentId))
            );
    }

    public function resetTournament()
    {
        $tournamentId = $this->request->getParameter("tournamentId");

        $this->tournamentService->reset($tournamentId);
    }
}