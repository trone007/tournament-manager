<?php
namespace Src\Assembler;

use Src\Model\Team;
use Src\Resources\ResourceInterface;
use Src\Resources\TeamResource;

class TeamResourceAssembler extends AbstractAssembler
{

    /**
     * @param $entity
     * @return ResourceInterface
     */
    public static function toResource($entity): ResourceInterface
    {
        /**
         * @var Team $entity
         */
        $resource = new TeamResource();
        $resource->setId($entity->getId());
        $resource->setName($entity->getName());

        return $resource;
    }
}