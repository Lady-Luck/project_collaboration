<?php namespace App\src\core\session;

interface SessionStorage {
    public function save($sessionId, $sessionData);
    public function load($sessionId);
    public function delete($sessionId);
}