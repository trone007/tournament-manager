<?php
namespace Core;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class EntityRepositoryConfigurator extends EntityRepository
{
    /**
     * Override Doctrine's EntityRepository constructor to intercept calls that do not have looked up the metadata yet.
     *
     * @param EntityManager $entityManager
     * @param ClassMetadata | string      $metadata
     */
    public function __construct(EntityManagerInterface $entityManager, $metadata = null)
    {
        if (is_null($metadata)) {
            $entityClassName = $this->getEntityClassNameFromRepositoryName();
            $metadata = $entityManager->getClassMetadata($entityClassName);
        }

        parent::__construct($entityManager, $metadata);
    }

    /**
     * Convert current RepositoryName to EntityName
     *
     * @return string
     */
    private function getEntityClassNameFromRepositoryName()
    {
        return str_replace("Src\\", $_ENV['ENTITY_NAMESPACE'], str_replace(array('Repository', '\\\\'), array('', '\\'), get_class($this)));
    }
}