<?php


namespace Src\Service;


use Src\Model\Tournament;

interface TournamentServiceInterface
{
    const HOME_TEAM='home';
    const AWAY_TEAM='away';
    /**
     * @return Tournament
     */
    public function getActiveTournament():Tournament;

    /**
     * @param int $tournamentId
     * @return array
     */
    public function getTournamentBracketByTournament(int $tournamentId): array;

    /**
     * @param int $tournamentId
     * @param int $gameNumber
     * @param int $teamId
     * @param string $teamPosition
     * @return mixed
     */
    public function setTournamentBracketTeam(int $tournamentId, int $gameNumber, int $teamId, string $teamPosition);

    /**
     * @param int $tournamentId
     * @param int $gameNumber
     * @param int $homeScore
     * @param int $awayScore
     * @param string $winner
     */
    public function saveScore(int $tournamentId, int $gameNumber, int $homeScore, int $awayScore, string $winner): void;

    /**
     * @param int $tournamentId
     * @return mixed
     */
    public function reset(int $tournamentId);
}