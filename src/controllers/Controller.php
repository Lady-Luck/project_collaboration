<?php namespace App\src\controllers;

use App\src\core\DatabaseConfiguration;
use App\src\core\DatabaseConnection;

class Controller {

    private $dbc;
    public $twig;

    private $data = [];

    final public function __construct()
    {
        $conf = new DatabaseConfiguration(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $this->dbc = new DatabaseConnection($conf);

        $this->loadTwig();

    }
    final public function &getDatabaseConnection() {
        return $this->dbc;
    }

    final public function getSession () {
        if(isset($_SESSION)) {
            return $_SESSION;
        }
        return null;
    }

    final public function getUser () {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        return null;
    }

    final public function sessionDestroy () {
        session_destroy();
    }

    final public function setSession($key, $value) {
        $_SESSION[$key] = $value;
    }

    private function loadTwig () {
        $loader = new \Twig_Loader_Filesystem("templates");
        $this->twig = new \Twig_Environment($loader, array(
            "cache" => "./twig-cache",
            "auto_reload" => true
        ));
        $this->twig->addGlobal('base_url', BASE_URL);
    }

    final public function getData () {
        return $this->data;
    }

    final protected function redirect ($path, $code = 307) {
        ob_clean();
        header('Location: '.$path, true, $code);
        exit;
    }
}