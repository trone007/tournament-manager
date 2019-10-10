<?php
namespace Src\Assembler;

use Src\Resources\ResourceInterface;

interface AssemblerInterface
{
    /**
     * @param $entity
     * @return ResourceInterface
     */
    public static function toResource($entity): ResourceInterface;

    /**
     * @param array $entity
     * @return array
     */
    public static function toResources(array $entities): array;
}