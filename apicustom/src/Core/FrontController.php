<?php

namespace App\Core;

use App\Core\Attributes\Route;
use ReflectionClass;

class FrontController
{

    public function run()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url_elements = explode('/', $url);
        $url_elements = array_slice($url_elements, 2);
        if (!empty($url_elements && !empty($url_elements[0]))) {
            $controller = 'App\Controllers\\' . ucfirst($url_elements[0]) . 'Controller';
            $method = !empty($url_elements[1]) ? $url_elements[1] : "index";
        } else {
            $controller = "App\Controllers\SiteController";
            $method = "index";
        }
        if (class_exists($controller)) {
            $controller_object = new $controller();
            $routes = [];
            $reflectionClass = new ReflectionClass($controller_object);
            $methodsList = $reflectionClass->getMethods();
            foreach ($methodsList as $reflectionMethod) {
                $atributes = $reflectionMethod->getAttributes(Route::class);
                foreach ($atributes as $attribute) {
                    if ($attribute->getName() === Route::class) {
                        /** @var Route $route */
                        $route = $attribute->newInstance();
                        $routes[$route->getPath()] = ['action' => $reflectionMethod->getName(),
                            'method' => $route->getMethod()];
                    }
                }
            }
            if (!empty($routes[$method]))
                $method = $routes[$method]['action'];


            if (method_exists($controller, $method)) {
                /**@var $response Response */
                $response = $controller_object->$method();
                if ($response instanceof Response) {
                    echo $response->getText();
                }
                if (gettype($response) === 'string') {
                    echo $response;
                }
            } else echo 'error 404';
        } else {
            echo "error 404";
        }
    }
}