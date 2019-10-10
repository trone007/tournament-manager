<?php
namespace Src\Assembler;

use Src\Model\TournamentBracket;
use Src\Resources\ResourceInterface;
use Src\Resources\TournamentBracketResource;

class TournamentBracketResourceAssembler extends AbstractAssembler
{

    /**
     * @param $entity
     * @return ResourceInterface
     */
    public static function toResource($entity): ResourceInterface
    {
        /**
         * @var TournamentBracket $entity
         */
        $resource = new TournamentBracketResource();
        $resource->setId($entity->getId());
        $resource->setGameNumber($entity->getGameNumber());

        if($entity->getRound())
            $resource->setRound(RoundResourceAssembler::toResource($entity->getRound()));
        if($entity->getHomeTeam())
            $resource->setHomeTeam(TeamResourceAssembler::toResource($entity->getHomeTeam()));

        if($entity->getAwayTeam())
            $resource->setAwayTeam(TeamResourceAssembler::toResource($entity->getAwayTeam()));

        if($entity->getWinner())
            $resource->setWinner(TeamResourceAssembler::toResource($entity->getWinner()));

        if($entity->getTournament())
            $resource->setTournament(TournamentResourceAssembler::toResource($entity->getTournament()));

        if(!is_null($entity->getHomeScore()))
            $resource->setHomeScore($entity->getHomeScore());

        if(!is_null($entity->getAwayScore()))
            $resource->setAwayScore($entity->getAwayScore());

        return $resource;
    }
}