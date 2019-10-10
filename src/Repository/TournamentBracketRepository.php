<?php
namespace Src\Repository;

use Src\Model\Round;
use Src\Model\Team;
use Src\Model\Tournament;
use Src\Model\TournamentBracket;

class TournamentBracketRepository extends BaseRepository
{
    /**
     * @param Team $homeTeam
     * @param Team $awayTeam
     * @param Tournament $tournament
     * @param Round $round
     * @return TournamentBracket
     */
    public function create(
        Team $homeTeam,
        Team $awayTeam,
        Tournament $tournament,
        Round $round
    ): TournamentBracket
    {
        $tournamentBracket = new TournamentBracket();
        $tournamentBracket->setHomeTeam($homeTeam);
        $tournamentBracket->setAwayTeam($awayTeam);
        $tournamentBracket->setTournament($tournament);
        $tournamentBracket->setRound($round);

        return $this->save($tournamentBracket);
    }

    /**
     * @param Tournament $tournamentId
     * @return array
     */
    public function getByTournamentId(Tournament $tournament): array
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('tb')
            ->from('Src\Model\TournamentBracket', 'tb')
            ->where('tb.tournament = :id')
            ->setParameter('id', $tournament)
            ->orderBy("tb.gameNumber", "ASC")
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $tournamentId
     * @return array
     */
    public function resetTournament(int $tournamentId)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->delete('Src\Model\TournamentBracket','tb')
            ->where('IDENTITY(tb.tournament) = :id')
            ->setParameter('id', $tournamentId)
            ->getQuery()
            ->execute()
        ;
    }
}