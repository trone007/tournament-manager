<?php


namespace Src\Service;


interface TeamServiceInterface
{
    /**
     * @return array
     */
    public function getAllTeams():array;

    /**
     * @param int $tournamentId
     * @param int $roundId
     * @return array
     */
    public function getAvailableTeam(int $tournamentId, int $roundId):array;

    /**
     * @param int $tournamentId
     * @return array|null
     */
    public function calculateTeamStatistics(int $tournamentId):?array;
}