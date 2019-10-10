<?php
namespace Src\Model;

use Doctrine\ORM\Annotation as ORM;
use Doctrine\ORM\Annotation\JoinColumn;
use Doctrine\ORM\Annotation\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="TournamentBracketRepository")
 * @ORM\Table(name="tournament_bracket")
 **/
class TournamentBracket implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @ManyToOne(targetEntity="Src\Model\Tournament")
     * @JoinColumn(name="tournament_id", referencedColumnName="id")
     * @var Tournament
     */
    private $tournament;

    /**
     * @ManyToOne(targetEntity="Src\Model\Round")
     * @JoinColumn(name="round_id", referencedColumnName="id")
     * @var Round
     */
    private $round;

    /**
     * @ManyToOne(targetEntity="Src\Model\Team")
     * @JoinColumn(name="home_team_id", referencedColumnName="id")
     * @var Team
     */
    private $homeTeam;

    /**
     * @ManyToOne(targetEntity="Src\Model\Team")
     * @JoinColumn(name="away_team_id", referencedColumnName="id")
     * @var Team
     */
    private $awayTeam;

    /**
     * @ManyToOne(targetEntity="Src\Model\Team")
     * @JoinColumn(name="winner_id", referencedColumnName="id")
     * @var Team
     */
    private $winner;

    /**
     * @ORM\Column(type="integer", name="home_score")
     * @var int
     */
    private $homeScore;

    /**
     * @ORM\Column(type="integer", name="away_score")
     * @var int
     */
    private $awayScore;

    /**
     * @ORM\Column(type="integer", name="game_number")
     * @var int
     */
    private $gameNumber;
    /**
     * @return Tournament
     */
    public function getTournament(): Tournament
    {
        return $this->tournament;
    }

    /**
     * @param Tournament $tournament
     */
    public function setTournament(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return Round
     */
    public function getRound(): Round
    {
        return $this->round;
    }

    /**
     * @param Round $round
     */
    public function setRound(Round $round)
    {
        $this->round = $round;
    }

    /**
     * @return Team
     */
    public function getHomeTeam(): ?Team
    {
        return $this->homeTeam;
    }

    /**
     * @param Team $homeTeam
     */
    public function setHomeTeam(Team $homeTeam)
    {
        $this->homeTeam = $homeTeam;
    }

    /**
     * @return Team
     */
    public function getAwayTeam(): ?Team
    {
        return $this->awayTeam;
    }

    /**
     * @param Team $awayTeam
     */
    public function setAwayTeam(Team $awayTeam)
    {
        $this->awayTeam = $awayTeam;
    }

    /**
     * @return int
     */
    public function getHomeScore(): ?int
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
    public function getAwayScore(): ?int
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
     * @return Team
     */
    public function getWinner(): ?Team
    {
        return $this->winner;
    }

    /**
     * @param Team $winner
     */
    public function setWinner(Team $winner)
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

}