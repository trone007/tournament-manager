<?php
namespace Src\Assembler;


abstract class AbstractAssembler implements AssemblerInterface
{
    /**
     * @param array $entities
     * @return array
     */
    public static function toResources(array $entities): array
    {
        $resources = [];
        foreach ($entities as $entity)
            $resources[] = static::toResource($entity)->toArray();

        return $resources;
    }
}