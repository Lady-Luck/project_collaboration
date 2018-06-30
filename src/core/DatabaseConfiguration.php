<?php namespace App\src\core;

class DatabaseConfiguration {

    private $host;
    private $user;
    private $password;
    private $name;

    public function __construct($host, $user, $password, $name)
    {
        $this->host     = $host;
        $this->user     = $user;
        $this->password = $password;
        $this->name     = $name;
    }

    public function getSourceString () {
        return "mysql:host={$this->host};dbname={$this->name};charset=utf8";
    }

    public function getUser () {
        return $this->user;
    }
    public function getPassword () {
        return $this->password;
    }

}