<?php
define('ROUTER', [
    '/404' => [
        'controller' => 'Src\\Controller\\ExceptionsController',
        'action' => 'page404',
        'method' => ['GET', 'POST']
    ],
    '/403' => [
        'controller' => 'Src\\Controller\\ExceptionsController',
        'action' => 'page403',
        'method' => ['GET', 'POST']
    ],
    '/405' => [
        'controller' => 'Src\\Controller\\ExceptionsController',
        'action' => 'page405',
        'method' => ['GET', 'POST']
    ],
    '/login' => [
        'controller' => 'Src\\Controller\\UserController',
        'action' => 'login',
        'method' => ['GET', 'POST']
    ],
    '/is-authenticated' => [
        'controller' => 'Src\\Controller\\UserController',
        'action' => 'isAuthenticated',
        'method' => ['GET']
    ],
    '/index' => [
        'controller' => 'Src\\Controller\\TaskController',
        'action' => 'index',
        'method' => ['GET']
    ],
    '/logout' => [
        'controller' => 'Src\\Controller\\UserController',
        'action' => 'logout',
        'method' => ['GET', 'POST']
    ],
    '/' => [
        'controller' => 'Src\\Controller\\TournamentController',
        'action' => 'drawGrid',
        'method' => ['GET']
    ],
    '/team-list' => [
        'controller' => 'Src\\Controller\\TeamController',
        'action' => 'getTeamList',
        'method' => ['GET']
    ],
    '/team-available-list' => [
        'controller' => 'Src\\Controller\\TeamController',
        'action' => 'getAvailableList',
        'method' => ['GET']
    ],
    '/statistic' => [
        'controller' => 'Src\\Controller\\TeamController',
        'action' => 'teamsStatistics',
        'method' => ['GET'],
        'forAuthenticated' => true
    ],
    '/active-tournament' => [
        'controller' => 'Src\\Controller\\TournamentController',
        'action' => 'getActiveTournament',
        'method' => ['GET']
    ],
    '/tournament-bracket' => [
        'controller' => 'Src\\Controller\\TournamentController',
        'action' => 'getTournamentBracket',
        'method' => ['GET']
    ],
    '/set-tournament-bracket-team' => [
        'controller' => 'Src\\Controller\\TournamentController',
        'action' => 'setTournamentBracketTeam',
        'method' => ['POST'],
        'forAuthenticated' => true
    ],
    '/set-result' => [
        'controller' => 'Src\\Controller\\TournamentController',
        'action' => 'setMatchResult',
        'method' => ['POST'],
        'forAuthenticated' => true
    ],
    '/reset' => [
        'controller' => 'Src\\Controller\\TournamentController',
        'action' => 'resetTournament',
        'method' => ['PUT'],
        'forAuthenticated' => true
    ]
]);
