<?php
namespace Src\Model;

use Doctrine\ORM\Annotation as ORM;
use Doctrine\ORM\Annotation\JoinColumn;
use Doctrine\ORM\Annotation\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="TournamentRepository")
 * @ORM\Table(name="tournament")
 **/
class Tournament implements EntityInterface
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
     * @ORM\Column(type="boolean", name="is_completed")
     * @var boolean
     */
    private $isCompleted;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ManyToOne(targetEntity="Src\Model\Round")
     * @JoinColumn(name="first_round_id", referencedColumnName="id")
     * @var Round
     */
    private $firstRound;


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    /**
     * @param bool $isCompleted
     */
    public function setIsCompleted(bool $isCompleted)
    {
        $this->isCompleted = $isCompleted;
    }

    /**
     * @return Round
     */
    public function getFirstRound(): Round
    {
        return $this->firstRound;
    }

    /**
     * @param Round $firstRound
     */
    public function setFirstRound(Round $firstRound)
    {
        $this->firstRound = $firstRound;
    }



}