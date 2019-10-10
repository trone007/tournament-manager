<?php
namespace Src\Resources;

class RoundResource implements ResourceInterface
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
    private $teamCount;

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
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
    public function setTeamCount(int $teamCount): void
    {
        $this->teamCount = $teamCount;
    }


    /**
     * @return array
     */
    public function toArray():array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "teamCount" => $this->teamCount
        ];
    }
}