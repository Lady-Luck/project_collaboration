<?php namespace App\src\core;

class DatabaseConnection {

    private $connection;
    private $configuration;

    public function __construct(DatabaseConfiguration $databaseConfiguration)
    {
        $this->configuration = $databaseConfiguration;
    }

    public function getConnection() {
        if (is_null($this->connection)) {
            try {
                $this->connection = new \PDO($this->configuration->getSourceString(),
                                             $this->configuration->getUser(),
                                             $this->configuration->getPassword());
                $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch(\PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return $this->connection;
    }
}