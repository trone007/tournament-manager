<?php
namespace Http;

use Src\Service\User\CredentialsService;

class Router
{
    /**
     * parse route and detect parameters
     * @param $url
     * @param Request $request
     */
    static public function parse($url, Request $request)
    {
        $urlParts = parse_url($url);

        $router = ROUTER[$urlParts['path']]?? false;

        if(!$router)
            self::pageNotFound();

        if(isset($router['forAuthenticated']) && $router['forAuthenticated'] && !CredentialsService::hasCredentials())
            self::wrongPermission();

        if (!in_array($_SERVER['REQUEST_METHOD'], $router['method']))
            self::methodNotAllowed();


        $request->setController($router['controller']);
        $request->setAction($router['action']);

        //for the bright future
        $request->setParams([]);
    }

    /**
     * to 404 page
     */
    static public function pageNotFound()
    {
        header('Location: /404');
        die();
    }

    /**
     * to 405 page
     */
    static public function methodNotAllowed()
    {
        header('Location: /405');
        die();
    }

    /**
     * to 403 page
     */
    static public function wrongPermission()
    {
        header('Location: /403');
        die();
    }
}