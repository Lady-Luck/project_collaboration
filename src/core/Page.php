<?php namespace App\src\core;

class Page {

    private $request;

    private $controllerPath = 'App\\src\\controllers\\';

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->loadPage();
    }

    private function loadPage () {

        $controllerName = $this->controllerPath . $this->request->getController();
        $controller = new $controllerName();

        $action     = $this->request->getAction();

        echo $response = $controller->$action($this->request);

    }
}