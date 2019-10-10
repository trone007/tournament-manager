<?php
namespace Http;

use DI\Container;

class Dispatcher
{
    /** @var Request */
    private $request;

    /** @var Container */
    private $container;

    /**
     * Dispatcher constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * dispatch route
     */
    public function dispatch()
    {
        $this->request = Request::getInstance();
        Router::parse($this->request->getUrl(), $this->request);
        $controller = $this->loadController();

        $this->container->call($controller, $this->request->getParams());
    }

    /**
     * check and get controller method
     * @return string
     */
    private function loadController(): string
    {
        $controller = $this->request->getController();
        $action = $this->request->getAction();

        if(!class_exists($controller) || !method_exists($controller, $action)) {
            Router::pageNotFound();
        }

        return $controller . '::' . $action;
    }


}
