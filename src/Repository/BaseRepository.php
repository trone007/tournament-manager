<?php


namespace Src\Repository;


use Core\EntityRepositoryConfigurator;
use Src\Model\EntityInterface;
use Src\Model\Team;

abstract class BaseRepository extends EntityRepositoryConfigurator
{
    /**
     * @param Team $task
     */
    public function save(EntityInterface $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}