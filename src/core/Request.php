<?php namespace App\src\core;

class Request
{

    private static $instance = null;

    public $url = null;

    # The data, either from the GET or POST
    public $data = array();

    public $method = 'GET';
    private $controller;
    private $action;

    # Params in route
    public $params = array();


    # Initialize the request object
    public static function init($request = null)
    {
        # Initialize if empty
        if (self::$instance == null) {
            self::$instance = new Request($request);
        }

        return self::$instance;
    }

    /**
     * Make request from URL
     */
    private function __construct($request = null)
    {

        if ($request === null) {
            $request = array_shift($_REQUEST);
        }

        # Get the URL
        $this->url = str_replace('/\.+/', '/', trim($request, '/ '));

        # Extract params
        $parts = explode('/', $this->url);
        $parts = array_slice($parts, 1);
        $this->params = $parts;

        $this->method = $_SERVER['REQUEST_METHOD'];

        # Find the page
        $routedParams = Router::route($this->url);
        if ($routedParams) {
            $this->controller = $routedParams['controller'];
            $this->action = $routedParams['action'];

            # Get the data
            foreach($_REQUEST as $key => $value) {
                $this->data[$key] = $value;
            }

            return $this;

        } else {

        }
    }

    public function getController () {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getData() {
        return $this->data;
    }

    public function getParams () {
        return $this->params;
    }
}