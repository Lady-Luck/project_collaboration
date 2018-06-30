<?php namespace App\src\core\session;

final class Session {
    private $sessionStorage;
    private $sessionData;
    private $sessionId;
    private $sessionLife;

    public function __construct(SessionStorage $sessionStorage, $sessionLife)
    {
        $this->sessionStorage = $sessionStorage;
        $this->sessionData = array();
        $this->sessionLife = $sessionLife;

        $this->sessionId = filter_input(INPUT_COOKIE, 'APPSESSION', FILTER_SANITIZE_STRING);
        $this->sessionId = preg_replace('|[^A-Za-z0-9]|', '', $this->sessionId);
    }

    public function put ($key, $value) {
        $this->sessionData[$key] = $value;
    }

    public function get ($key) {
        return $this->sessionData[$key] ? $this->sessionData[$key] : null;
    }

    public function clear () {
        $this->sessionData = array();
    }

    public function exists ($key) {
        return isset($this->sessionData[$key]);
    }

    public function has ($key) {
        if (!$this->exists($key)) {
            return false;
        }
        return boolval($this->sessionData[$key]);
    }

    public function save () {
        $jsonData = json_encode($this->sessionData);
        $this->sessionStorage->save($this->sessionId, $jsonData);
    }

    public function reload () {
        $jsonData = $this->sessionStorage->load($this->sessionId);
        $restoredData = json_decode($jsonData);
        if (!$restoredData) {
          $this->sessionData = array();
            return;
        }
        $this->sessionData = $restoredData;
    }

}