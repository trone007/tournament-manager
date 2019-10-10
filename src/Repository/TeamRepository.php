<?php
namespace Src\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\ResultSetMapping;
use Src\Model\Round;
use Src\Model\Team;
use Src\Model\Tournament;

class TeamRepository extends BaseRepository
{
    /**
     * @param int $offset
     * @param string $orderBy
     * @param string $orderDirection
     * @return Team[]
     */
    public function getTeamList(): array
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('t')
            ->from('Src\Model\Team', 't')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param Tournament $tournament
     * @param Round $round
     * @return Team[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getActiveTeamList(Tournament $tournament, Round $round): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id','id', Type::getType(Type::INTEGER));
        $rsm->addScalarResult('name','text', Type::getType(Type::STRING));

        return $this->getEntityManager()
            ->createNativeQuery('
                SELECT t0.id AS id, t0.name AS name
                FROM team t0
                    WHERE t0.id NOT IN
                    (
                      SELECT DISTINCT t1.home_team_id 
                      FROM tournament_bracket t1 
                      WHERE t1.round_id = :round AND t1.tournament_id = :tournament AND t1.home_team_id IS NOT NULL
                      UNION ALL 
                      SELECT DISTINCT t1.away_team_id FROM tournament_bracket 
                      t1 
                      WHERE t1.round_id = :round AND t1.tournament_id = :tournament AND t1.away_team_id IS NOT NULL
                    );
            ',$rsm)
            ->setParameter('tournament', $tournament->getId())
            ->setParameter('round', $round->getId())
            ->getResult()
        ;
    }

    /**
     * @return array|null
     * @throws \Doctrine\DBAL\DBALException
     */
    public function calculateTeamsStatistic(): ?array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id','id', Type::getType(Type::INTEGER));
        $rsm->addScalarResult('name','name', Type::getType(Type::STRING));
        $rsm->addScalarResult('lastGame','lastGame', Type::getType(Type::INTEGER));
        $rsm->addScalarResult('scored','scored', Type::getType(Type::INTEGER));
        $rsm->addScalarResult('maxScored','maxScored', Type::getType(Type::INTEGER));
        $rsm->addScalarResult('averageScored','averageScored', Type::getType(Type::INTEGER));
        $rsm->addScalarResult('missed','missed', Type::getType(Type::INTEGER));

        return $this->getEntityManager()
            ->createNativeQuery('
                WITH max_scored as(
                    SELECT t.id, MAX (CASE WHEN t.id = tb.home_team_id THEN home_score ELSE away_score END) as maxScored
                    FROM team t
                             JOIN tournament_bracket tb ON (t.id = tb.home_team_id OR t.id = tb.away_team_id )
                    GROUP BY 1
                )
                SELECT
                       t.id,
                       t.name,
                       ms.maxScored,
                       MAX(game_number) as lastGame,
                       MAX(round_id) as lastRound,
                       SUM (CASE WHEN t.id = tb.home_team_id THEN home_score ELSE away_score END) as scored,
                       SUM (CASE WHEN t.id = tb.home_team_id THEN away_score ELSE home_score END) as missed,
                       AVG (CASE WHEN t.id = tb.home_team_id THEN home_score ELSE away_score END) as averageScored
                FROM team t
                    JOIN tournament_bracket tb ON (t.id = tb.home_team_id OR t.id = tb.away_team_id )
                    JOIN round r ON tb.round_id = r.id
                    LEFT JOIN max_scored ms ON t.id = ms.id
                GROUP BY 1,2
                ORDER BY r."order" DESC
            ',$rsm)
            ->getResult()
            ;

    }
}