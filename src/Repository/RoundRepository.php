<?php
namespace Src\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Query\ResultSetMapping;
use Src\Model\Round;

class RoundRepository extends BaseRepository
{
    /**
     * @param int $offset
     * @param string $orderBy
     * @param string $orderDirection
     * @return int
     */
    public function getRoundIdByGameNumber(int $roundId, int $number): int
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id', Type::getType(Type::INTEGER));

        return $this->getEntityManager()
            ->createNativeQuery("
                WITH data as (SELECT
                    id,
                    SUM(SUM(team_count)/2) OVER (ORDER BY id ASC) AS game_number
                FROM round
                WHERE id >= :round
                GROUP BY 1
                ORDER BY 1 
                )
                
                SELECT id as id FROM data WHERE game_number >= :n LIMIT 1
            ",$rsm
            )
            ->setParameter('n', $number)
            ->setParameter('round', $roundId)
            ->getSingleScalarResult()
            ;
    }

    /**
     * @param Round $round
     * @return array|null
     */
    public function getChildRoundsByRound(Round $round) :?array
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('r')
            ->from('Src\Model\Round', 'r')
            ->where('r.parent = :round')
            ->setParameter('round', $round)
            ->getQuery()
            ->getResult();
    }

}