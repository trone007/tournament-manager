<?php
namespace Src\Assembler;

use Src\Model\Round;
use Src\Resources\ResourceInterface;
use Src\Resources\RoundResource;

class RoundResourceAssembler extends AbstractAssembler
{

    /**
     * @param $entity
     * @return ResourceInterface
     */
    public static function toResource($entity): ResourceInterface
    {
        /**
         * @var Round $entity
         */
        $resource = new RoundResource();
        $resource->setId($entity->getId());
        $resource->setName($entity->getName());
        $resource->setTeamCount($entity->getTeamCount());

        return $resource;
    }
}