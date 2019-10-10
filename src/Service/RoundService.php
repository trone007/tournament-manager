<?php


namespace Src\Service;


use Src\Model\Round;
use Src\Model\Tournament;
use Src\Repository\RoundRepository;

class RoundService implements RoundServiceInterface
{
    /**
     * @var RoundRepository
     */
    private $roundRepository;

    public function __construct(RoundRepository $roundRepository)
    {
        $this->roundRepository = $roundRepository;
    }

    public function getRoundByGameNumber(Tournament $tournament, int $gameNumber): ?Round
    {
        $roundId = $this->roundRepository->getRoundIdByGameNumber($tournament->getFirstRound()->getId(), $gameNumber);

        /**
         * @var Round $round
         */
        $round = $this->roundRepository->find($roundId);

        return $round;
    }

    /**
     * @param Round $round
     * @return array|null
     */
    public function getNextRoundsByRound(Round $round): ?array
    {
        return $this->roundRepository->getChildRoundsByRound($round);
    }
}