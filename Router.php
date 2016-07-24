<?php

include_once("controller/NewsController.php");
include_once("controller/PageController.php");

class Router
{
    private static $instance = null;
    private $config;

    const CONTROLLER = "controller";

    const DELIM = "/";

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    public function route($params)
    {
        $r = $params['r'];
        if (isset($r) && empty($r)) {
            throw new Exception("Invalid route");
        }

        $routeArray = explode(self::DELIM, $r);
        $routeArrayLength = count($routeArray);
        $controller = $routeArray[0];
        $controllerRoutes = $this->getControllerRoutes($controller);

        $routesWithTheSameLength = array();
        foreach ($controllerRoutes as $crKey => $cAction) {
            $crKeyArray = explode(self::DELIM, $crKey);
            if ($routeArrayLength == count($crKeyArray)) {
                $routesWithTheSameLength[$crKey] = $cAction;
            }
        }

        $finalRoutes = array();
        $routeValues = array();
        foreach ($routesWithTheSameLength as $crKey => $cAction) {
            $crKeyArray = explode(self::DELIM, $crKey);
            foreach ($routeArray as $key => $value) {

                if (strpos($crKeyArray[$key], "{") !== false) {
                    $routeValues[] = $value;
                    continue;
                }
                if ($crKeyArray[$key] != $value) {
                    break;
                }
                if (count($finalRoutes) == 0) {
                    $finalRoutes[] = $cAction;
                }
            }
        }

        $controllerArrayName = explode(":", $finalRoutes[0][self::CONTROLLER]);
        $controllerName = $controllerArrayName[0];

        $controllerInstance = new $controllerName();


        $action = isset($controllerArrayName[1]) ? $controllerArrayName[1] : "index"; 
        call_user_func_array(array($controllerInstance, $action), $routeValues);


        //TODO: fix side effect with not equal route


    }

    private function __construct()
    {
        $this->config = $this->routeConfig();
    }

    private function getControllerRoutes($name)
    {
        $routes = array();
        foreach ($this->config as $key => $config) {
            if (strpos($key, $name) !== false) {
                $routes[$key] = $config;
            }
        }
        return $routes;
    }

    private function routeConfig()
    {
        return array(
            "page/{id}" => array(
                self::CONTROLLER => "PageController"
            ),
            "page/{id}/rest" => array(
                self::CONTROLLER => "PageController:indexRestStyle"
            ),
            "page/{id}/addComment" => array(
                self::CONTROLLER => "PageController:addComment"
            ),
            "news/{id}" => array(
                self::CONTROLLER => "NewsController"
            )
        );
    }
}
