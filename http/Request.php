<?php
namespace Http;

class Request
{
    private $url;
    private $post;
    private $get;
    private $controller;
    private $action;
    private $params;
    private $file;

    private static $_instance = null;

    /**
     * Request constructor.
     */
    private function __construct()
    {
        $this->url = $_SERVER["REQUEST_URI"];
        $this->post = $_POST;
        $this->get = $_GET;
    }

    protected function __clone() {
    }

    /**
     * may be singleton needed
     * @return Request|null
     */
    static public function getInstance() {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * get POST parameter
     * @param string $key
     * @param null $default
     * @return null|string
     */
    public function postParameter(string $key, $default = null)
    {
        return isset($this->post[$key]) ?
            $this->secureInputData($this->post[$key])
            :
            $default;
    }

    /**
     * get GET parameter
     * @param string $key
     * @return mixed|null
     */
    public function getParameter(string $key, $default = null)
    {
        return isset($this->get[$key]) ?
            $this->secureInputData($this->get[$key])
            :
            $default;
    }


    /**
     * @param string $key
     * @return mixed|null
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * get action name from route
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * get controller name from route
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * check request is post type
     * @return bool
     */
    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * check request is get type
     * @return bool
     */
    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * validate data from request strings
     * @param $data
     * @return string
     */
    private function secureInputData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}