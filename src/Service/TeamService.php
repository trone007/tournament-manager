<?php


namespace Src\Service;


use Src\Model\Round;
use Src\Model\Tournament;
use Src\Repository\RoundRepository;
use Src\Repository\TeamRepository;
use Src\Repository\TournamentRepository;

class TeamService implements TeamServiceInterface
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * @var TournamentRepository
     */
    private $tournamentRepository;

    /**
     * @var RoundRepository
     */
    private $roundRepository;

    /**
     * UserService constructor.
     * @param TeamRepository $teamRepository
     * @param TournamentRepository $tournamentRepository
     * @param RoundRepository $roundRepository
     */
    public function __construct(
        TeamRepository $teamRepository,
        TournamentRepository $tournamentRepository,
        RoundRepository $roundRepository
    )
    {
        $this->teamRepository = $teamRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->roundRepository = $roundRepository;
    }

    /**
     * @return array
     */
    public function getAllTeams(): array
    {
        return $this->teamRepository->getTeamList();
    }

    /**
     * @param int $tournamentId
     * @param int $roundId
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getAvailableTeam(int $tournamentId, int $roundId): array
    {
        /**
         * @var Round $round
         */
        $round = $this->roundRepository->find($roundId);
        if(!$round)
            return [];

        /**
         * @var Tournament $tournament
         */
        $tournament = $this->tournamentRepository->find($tournamentId);
        if(!$tournament)
            return [];

        return $this->teamRepository->getActiveTeamList($tournament, $round);
    }

    /**
     * @param int $tournamentId
     * @return array|null
     * @throws \Doctrine\DBAL\DBALException
     */
    public function calculateTeamStatistics(int $tournamentId):?array
    {
        return $this->teamRepository->calculateTeamsStatistic($tournamentId);
    }
}