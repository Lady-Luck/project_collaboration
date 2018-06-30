<?php namespace App\src\core;

class Router {

    private static $routes = array();

    public static function add($controller, $action, $regex) {
        self::$routes[$regex] = array(
            'controller' => $controller,
            'action' => $action
        );
    }

    public static function route($url) {

        # Try to locate the route
        foreach(self::$routes as $regexp => $params) {
            if(preg_match("~^{$regexp}$~ u", $url, $match)) {
                return self::$routes[$regexp];

            }
        }
    }
}
