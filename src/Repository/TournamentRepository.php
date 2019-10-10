<?php
namespace Src\Repository;

use Src\Model\Tournament;

class TournamentRepository extends BaseRepository
{
    /**
     * @param int $offset
     * @param string $orderBy
     * @param string $orderDirection
     * @return Tournament
     */
    public function getActiveTournament(): Tournament
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('t')
            ->from('Src\Model\Tournament', 't')
            ->where('t.isCompleted = false')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param int $offset
     * @param string $orderBy
     * @param string $orderDirection
     * @return Tournament
     */
    public function getById(int $tournamentId): Tournament
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('t')
            ->from('Src\Model\Tournament', 't')
            ->where('t.id = :id')
            ->setParameter('id', $tournamentId)
            ->getQuery()
            ->getResult()
        ;
    }
}