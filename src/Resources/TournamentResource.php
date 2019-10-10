<?php
namespace Src\Resources;

class TournamentResource implements ResourceInterface
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;


    /**
     * @var int
     */
    private $firstRoundId;

    /**
     * @var int
     */
    private $firstRoundTeamCount;
    /**
     * @var boolean
     */
    private $isCompleted;

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
     * @return int
     */
    public function getFirstRoundId(): int
    {
        return $this->firstRoundId;
    }

    /**
     * @param int $firstRoundId
     */
    public function setFirstRoundId(int $firstRoundId)
    {
        $this->firstRoundId = $firstRoundId;
    }

    /**
     * @return int
     */
    public function getFirstRoundTeamCount(): int
    {
        return $this->firstRoundTeamCount;
    }

    /**
     * @param int $firstRoundTeamCount
     */
    public function setFirstRoundTeamCount(int $firstRoundTeamCount)
    {
        $this->firstRoundTeamCount = $firstRoundTeamCount;
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
     * @return array
     */
    public function toArray():array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "firstRoundId" => $this->firstRoundId,
            "firstRoundTeamCount" => $this->firstRoundTeamCount,
            "isCompleted" => $this->isCompleted
        ];
    }
}