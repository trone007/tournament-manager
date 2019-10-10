<?php
namespace Src\Assembler;

use Src\Model\Tournament;
use Src\Resources\ResourceInterface;
use Src\Resources\TournamentResource;

class TournamentResourceAssembler extends AbstractAssembler
{

    /**
     * @param $entity
     * @return ResourceInterface
     */
    public static function toResource($entity): ResourceInterface
    {
        /**
         * @var Tournament $entity
         */
        $resource = new TournamentResource();
        $resource->setId($entity->getId());
        $resource->setName($entity->getName());
        $resource->setFirstRoundId($entity->getFirstRound()->getId());
        $resource->setFirstRoundTeamCount($entity->getFirstRound()->getTeamCount());
        $resource->setIsCompleted($entity->isCompleted());

        return $resource;
    }
}