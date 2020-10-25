<?php


namespace app\engine;


class Router
{
    private $routes = [
        '/' => 'index@self',
        '/api/save' => 'api@save',
        '/api/unload' => 'api@unload',
    ];

    protected $controllerName;
    protected $actionName;
    protected $actionParams;

    public function __construct()
    {
        $this->route();
    }

    private function route()
    {
        $request = $_SERVER['REQUEST_URI'];
        foreach ($this->routes as $key => $value) {
            if ($request == $key) {
                $value = explode('@', $value);
                $this->controllerName = $value[0];
                $this->actionName = $value[1];
            }
        }
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    public function getActionParams()
    {
        return $this->actionParams;
    }
}