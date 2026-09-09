<?php

namespace AuthorizationSystem;

class Router 
{
    private $currentPath;

    private $currentController;

    function __construct()
    {
        $currentPath = $this->detectCurrentPath();
        $this->setCurrentPath($currentPath);
    }

    public function getCurrentPath()
    {
        return $this->currentPath;
    }

    private function detectCurrentPath()
    {
        $UrlParser = new UrlParser;
        $path = $UrlParser->parseUrl();

        $requestController = array_shift($path);
        $standardController = STANDARD_CONTROLLER;

        if (!empty($requestController)) {

            return $requestController;

        } else {
            return $standardController;
        }
    }

    public function detectCurrentController()
    {
        $currentPath = $this->getCurrentPath();

        $controller = $this->searchController($currentPath);

        if ($controller === false) {
            
            $pathTo404 = CONTROLLERS_PATH . '/' . CONTROLLER_404;

            return $pathTo404;

        } else {
            return $controller;
        }
    }

    public function searchController($controller)
    {
        $controllersPath = CONTROLLERS_PATH;
        $controllerPath = "{$controllersPath}/{$controller}.php";

        if (file_exists($controllerPath) !== false) {

            return $controllerPath;

        } else {
            return false;
        }
    }

    private function setCurrentPath($path)
    {
        $this->currentPath = $path;
    }

    private function setUrl($url)
    {
        $this->url = $url;
    }
}
