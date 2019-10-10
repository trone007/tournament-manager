<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Src\Service\RoundService;
use Src\Service\RoundServiceInterface;
use Src\Service\TeamService;
use Src\Service\TeamServiceInterface;
use Src\Service\TournamentService;
use Src\Service\TournamentServiceInterface;
use Src\Service\User\CredentialsService;
use Src\Service\User\CredentialsServiceInterface;
use Src\Service\User\UserService;
use Src\Service\User\UserServiceInterface;


return [
    // Configure EntityManagerInterface realization
    EntityManagerInterface::class => function() {
        $isDevMode = boolval($_ENV['DEV_MODE']);
        $entityPath = [sprintf('%s/../%s', __DIR__, $_ENV['ENTITY_DIRECTORY'])];

        $config = Setup::createAnnotationMetadataConfiguration($entityPath, $isDevMode);

        $conn = array(
            'driver' => $_ENV['DB_DRIVER'],
            'path' => $_ENV['DB_PATH'],
        );

        return EntityManager::create($conn, $config);
    },
    // Configure Twig
    \Twig\Environment::class => function () {
        $loader = new \Twig\Loader\FilesystemLoader(VIEWS_ROOT);
        return new \Twig\Environment($loader);
    },

    CredentialsServiceInterface::class => DI\get(CredentialsService::class),
    TeamServiceInterface::class => DI\get(TeamService::class),
    TournamentServiceInterface::class => DI\get(TournamentService::class),
    RoundServiceInterface::class => DI\get(RoundService::class),
    UserServiceInterface::class => DI\get(UserService::class)
];