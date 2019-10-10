<?php


namespace Src\Service;


use Src\Exceptions\WrongParametersException;
use Src\Model\Round;
use Src\Model\Team;
use Src\Model\Tournament;
use Src\Model\TournamentBracket;
use Src\Repository\TeamRepository;
use Src\Repository\TournamentBracketRepository;
use Src\Repository\TournamentRepository;

class TournamentService implements TournamentServiceInterface
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;
    /**
     * @var TournamentRepository
     */
    private $tournamentRepository;
    /**
     * @var TournamentBracketRepository
     */
    private $tournamentBracketRepository;

    /**
     * @var RoundServiceInterface
     */
    private $roundService;

    /**
     * UserService constructor.
     * @param TeamRepository $teamRepository
     * @param TournamentRepository $tournamentRepository
     * @param TournamentBracketRepository $tournamentBracketRepository
     * @param RoundServiceInterface $roundService
     */
    public function __construct(
        TeamRepository $teamRepository,
        TournamentRepository $tournamentRepository,
        TournamentBracketRepository $tournamentBracketRepository,
        RoundServiceInterface $roundService
    )
    {
        $this->teamRepository = $teamRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->tournamentBracketRepository = $tournamentBracketRepository;
        $this->roundService = $roundService;
    }

    public function getActiveTournament(): Tournament
    {
        return $this->tournamentRepository->getActiveTournament();
    }

    public function getTournamentBracketByTournament(int $tournamentId): array
    {
        /**
         * @var Tournament $tournament
         */
        $tournament = $this->tournamentRepository->find($tournamentId);
        if($tournament)
            return $this->tournamentBracketRepository->getByTournamentId($tournament);

        return [];
    }

    /**
     * @param int $tournamentId
     * @param int $gameNumber
     * @param int $homeScore
     * @param int $awayScore
     * @param string $winnerOption
     * @throws WrongParametersException
     */
    public function saveScore(int $tournamentId, int $gameNumber, int $homeScore, int $awayScore, string $winnerOption): void
    {
        /**
         * @var Tournament $tournament
         */
        $tournament = $this->tournamentRepository->find($tournamentId);
        if(!$tournament)
            throw new WrongParametersException();


        /**
         * @var TournamentBracket $tournamentBracket
         */
        $tournamentBracket = $this->tournamentBracketRepository->findOneBy([
            'tournament' => $tournament,
            'gameNumber' => $gameNumber
        ]);


        if(!$tournamentBracket)
            throw new WrongParametersException();
        list($looser, $winner) = $this->detectWinner($tournamentBracket, $homeScore, $awayScore, $winnerOption);

        if(!$winner)
            return;

        $tournamentBracket->setWinner($winner);
        $tournamentBracket->setHomeScore($homeScore);
        $tournamentBracket->setAwayScore($awayScore);

        $nextRounds = $this->roundService->getNextRoundsByRound($tournamentBracket->getRound());

        if(!$nextRounds) {
            $this->tournamentBracketRepository->save($tournamentBracket);
            return;
        }

        if(count($nextRounds) == 2) {
            $this->nextMatch($winner, $tournamentBracket, $gameNumber, $nextRounds[0]);
            $this->nextMatch($looser, $tournamentBracket, $gameNumber, $nextRounds[1]);
            return;
        }

        $this->nextMatch($winner, $tournamentBracket, $gameNumber, $nextRounds[0]);
    }

    /**
     * @param TournamentBracket $tournamentBracket
     * @param int $homeScore
     * @param int $awayScore
     * @param string $winnerOption
     * @return array
     */
    private function detectWinner(TournamentBracket $tournamentBracket, int $homeScore, int $awayScore, string $winnerOption)
    {
        if($homeScore === $awayScore)
            switch($winnerOption){
                case self::HOME_TEAM:
                    return [
                        $tournamentBracket->getAwayTeam(),
                        $tournamentBracket->getHomeTeam(),
                        ];
                break;
                case self::AWAY_TEAM:
                    return [
                        $tournamentBracket->getHomeTeam(),
                        $tournamentBracket->getAwayTeam(),
                    ];
                    break;
                default:
                    return [null,null];
                    break;
            }
        return $homeScore < $awayScore ?
            [ $tournamentBracket->getHomeTeam(), $tournamentBracket->getAwayTeam()] :
                [ $tournamentBracket->getAwayTeam(), $tournamentBracket->getHomeTeam()];
    }

    /**
     * @param Team $team
     * @param TournamentBracket $tournamentBracket
     * @param int $gameNumber
     * @param Round $nextRound
     */
    private function nextMatch(Team $team, TournamentBracket $tournamentBracket, int &$gameNumber, Round $nextRound)
    {
        if($gameNumber % 2 === 0) {
            $gameNumber--;
        }

        $gameNumber = ceil($gameNumber/2);
        $gameNumber += ($tournamentBracket->getTournament()->getFirstRound()->getTeamCount() / 2);

        $nextTournamentBracket = $this->tournamentBracketRepository->findOneBy([
            'tournament' => $tournamentBracket->getTournament(),
            'gameNumber' => $gameNumber
        ]);

        if(!$nextTournamentBracket)
            $nextTournamentBracket = new TournamentBracket();

        $nextTournamentBracket->setRound($nextRound);
        $nextTournamentBracket->setTournament($tournamentBracket->getTournament());
        $nextTournamentBracket->setGameNumber($gameNumber);

        if(!$nextTournamentBracket->getHomeTeam() && $tournamentBracket->getGameNumber() % 2 !== 0) {
            $nextTournamentBracket->setHomeTeam($team);
            $this->tournamentBracketRepository->save($nextTournamentBracket);

            return;
        }

        if(!$nextTournamentBracket->getAwayTeam() && $tournamentBracket->getGameNumber() % 2 === 0) {
            $nextTournamentBracket->setAwayTeam($team);
            $this->tournamentBracketRepository->save($nextTournamentBracket);

            return;
        }

    }

    /**
     * @param int $tournamentId
     * @param int $gameNumber
     * @param int $teamId
     * @param string $teamPosition
     * @return mixed
     * @throws WrongParametersException
     */
    public function setTournamentBracketTeam(int $tournamentId, int $gameNumber, int $teamId, string $teamPosition)
    {
        /**
         * @var Tournament $tournament
         */
        $tournament = $this->tournamentRepository->find($tournamentId);
        if(!$tournament)
            throw new WrongParametersException();

        /**
         * @var Round $round
         */
        $round = $this->roundService->getRoundByGameNumber($tournament, $gameNumber);
        if(!$round)
            throw new WrongParametersException();

        /**
         * @var Team $team
         */
        $team = $this->teamRepository->find($teamId);
        if(!$team)
            throw new WrongParametersException();


        if(!$this->checkTeamPosition($teamPosition))
            throw new WrongParametersException();

        $tournamentBracket = $this->tournamentBracketRepository->findOneBy([
            'tournament'=> $tournament,
            'round'=> $round,
            'gameNumber' => $gameNumber
        ]);

        if(!$tournamentBracket)
            $tournamentBracket = new TournamentBracket();

        $tournamentBracket->setGameNumber($gameNumber);
        $tournamentBracket->setRound($round);
        $tournamentBracket->setTournament($tournament);

        switch ($teamPosition) {
            case self::HOME_TEAM:
                $tournamentBracket->setHomeTeam($team);
                break;
            case self::AWAY_TEAM:
                $tournamentBracket->setAwayTeam($team);
                break;
        }

        $this->tournamentBracketRepository->save($tournamentBracket);
    }


    private function checkTeamPosition(string $teamPosition):bool
    {
        switch ($teamPosition){
            case self::HOME_TEAM:
            case self::AWAY_TEAM:
                return true;
                break;
            default:
                return false;
        }
    }

    /**
     * @param int $tournamentId
     * @return mixed
     */
    public function reset(int $tournamentId)
    {
        $this->tournamentBracketRepository->resetTournament($tournamentId);
    }
}