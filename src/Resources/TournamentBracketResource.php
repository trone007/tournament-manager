<?php
namespace Src\Resources;

class TournamentBracketResource implements ResourceInterface
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var ResourceInterface
     */
    private $tournament;

    /**
     * @var ResourceInterface
     */
    private $homeTeam;

    /**
     * @var ResourceInterface
     */
    private $round;

    /**
     * @var ResourceInterface
     */
    private $awayTeam;

    /**
     * @var ResourceInterface
     */
    private $winner;

    /**
     * @var int
     */
    private $homeScore;

    /**
     * @var int
     */
    private $awayScore;


    /**
     * @var int
     */
    private $gameNumber;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return ResourceInterface
     */
    public function getTournament(): ResourceInterface
    {
        return $this->tournament;
    }

    /**
     * @param ResourceInterface $tournament
     */
    public function setTournament(ResourceInterface $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return ResourceInterface
     */
    public function getHomeTeam(): ResourceInterface
    {
        return $this->homeTeam;
    }

    /**
     * @param ResourceInterface $homeTeam
     */
    public function setHomeTeam(ResourceInterface $homeTeam)
    {
        $this->homeTeam = $homeTeam;
    }

    /**
     * @return ResourceInterface
     */
    public function getAwayTeam(): ResourceInterface
    {
        return $this->awayTeam;
    }

    /**
     * @param ResourceInterface $awayTeam
     */
    public function setAwayTeam(ResourceInterface $awayTeam)
    {
        $this->awayTeam = $awayTeam;
    }

    /**
     * @return int
     */
    public function getHomeScore(): int
    {
        return $this->homeScore;
    }

    /**
     * @param int $homeScore
     */
    public function setHomeScore(int $homeScore)
    {
        $this->homeScore = $homeScore;
    }

    /**
     * @return int
     */
    public function getAwayScore(): int
    {
        return $this->awayScore;
    }

    /**
     * @param int $awayScore
     */
    public function setAwayScore(int $awayScore)
    {
        $this->awayScore = $awayScore;
    }

    /**
     * @return ResourceInterface
     */
    public function getWinner(): ResourceInterface
    {
        return $this->winner;
    }

    /**
     * @param ResourceInterface $winner
     */
    public function setWinner(ResourceInterface $winner)
    {
        $this->winner = $winner;
    }

    /**
     * @return int
     */
    public function getGameNumber(): int
    {
        return $this->gameNumber;
    }

    /**
     * @param int $gameNumber
     */
    public function setGameNumber(int $gameNumber): void
    {
        $this->gameNumber = $gameNumber;
    }

    /**
     * @return ResourceInterface
     */
    public function getRound(): ResourceInterface
    {
        return $this->round;
    }

    /**
     * @param ResourceInterface $round
     */
    public function setRound(ResourceInterface $round): void
    {
        $this->round = $round;
    }




    /**
     * @return array
     */
    public function toArray():array
    {
        return [
            "id" => $this->id,
            "tournament" => $this->tournament ? $this->tournament->toArray() : $this->tournament,
            "round" => $this->round ? $this->round->toArray() : $this->round,
            "homeTeam" => $this->homeTeam ? $this->homeTeam->toArray() : $this->homeTeam,
            "awayTeam" => $this->awayTeam ? $this->awayTeam->toArray() : $this->awayTeam,
            "winner"  => $this->winner ? $this->winner->toArray() : $this->winner,
            "homeScore"  => $this->homeScore,
            "awayScore"  => $this->awayScore,
            "gameNumber"  => $this->gameNumber
        ];
    }
}