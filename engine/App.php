<?php


namespace app\engine;


use app\model\repositories\UserRepository;
use app\traits\TSingletone;

/**
 * Class App
 * @property Request $request
 * @property Google $google
 * @property UserRepository $usersRepository
 * @property Db $db
 * @property Session $session
 * @property Router $router
 */
class App
{
    use TSingletone;
    public $config;

    /** @var  Storage */
    //хранилище компонентов-объектов
    private $components;

    private $controller;
    private $action;

    /**
     * @return static
     */
    public static function call()
    {
        return static::getInstance();
    }

    public function runController()
    {
        $this->session->sessionStart();

        $controllerName = $this->router->getControllerName() ?: die('Ошибка 404. Контроллер не существует.');
        $actionName = $this->router->getActionName();
        $actionParams = $this->router->getActionParams();

        $controllerClass = $this->config['controllers_namespaces'] . ucfirst($controllerName) . "Controller";
        $controller = new $controllerClass(new Renderer($this->config['templates_dir']));
        $controller->runAction($actionName, $actionParams);
    }

    //создание компонента при обращении, возвращает объект для хранилища
    public function createComponent($name)
    {
        if (isset($this->config['components'][$name])) {
            $params = $this->config['components'][$name];
            $class = $params['class'];
            if (class_exists($class)) {
                unset($params['class']);
                $reflection = new \ReflectionClass($class);
                return $reflection->newInstanceArgs($params);
            }
        }
        return null;
    }

    public function createRepoComponent($name)
    {
        if (isset($this->config['components']['repositories'][$name])) {
            $class = $this->config['components']['repositories'][$name]['class'];
            if (class_exists($class)) {
                return new $class;
            }
        }
        return null;
    }

    public function run($config)
    {
        $this->config = $config;
        $this->components = new Storage();
        $this->runController();
    }

    function __get($name)
    {
        return $this->components->get($name) ?: $this->components->getRepo($name);
    }

}