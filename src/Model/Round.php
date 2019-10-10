<?php
namespace Src\Model;

use Doctrine\ORM\Annotation as ORM;
use Doctrine\ORM\Annotation\JoinColumn;
use Doctrine\ORM\Annotation\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="RoundRepository")
 * @ORM\Table(name="round")
 **/
class Round implements EntityInterface
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
     * @ManyToOne(targetEntity="Src\Model\Round")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     * @var Round
     */
    private $parent;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="integer", name="team_count")
     * @var int
     */
    private $teamCount;

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
     * @return int
     */
    public function getTeamCount(): int
    {
        return $this->teamCount;
    }

    /**
     * @param int $teamCount
     */
    public function setTeamCount(int $teamCount)
    {
        $this->teamCount = $teamCount;
    }

    /**
     * @return Round
     */
    public function getParent(): Round
    {
        return $this->parent;
    }

    /**
     * @param Round $parent
     */
    public function setParent(Round $parent)
    {
        $this->parent = $parent;
    }



}