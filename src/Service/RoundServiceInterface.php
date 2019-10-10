<?php


namespace Src\Service;


use Src\Model\Round;
use Src\Model\Tournament;

interface RoundServiceInterface
{
    /**
     * @param Tournament $tournament
     * @param int $gameNumber
     * @return Round|null
     */
    public function getRoundByGameNumber(Tournament $tournament, int $gameNumber): ?Round;
    public function getNextRoundsByRound(Round $round): ?array;
}