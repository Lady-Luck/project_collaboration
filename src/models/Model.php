<?php namespace App\src\models;

abstract class Model {
    private $dbc;

    public function __construct(\App\src\core\DatabaseConnection &$dbc)
    {
        $this->dbc = $dbc;
    }

    final protected function getConnection() {
        return $this->dbc->getConnection();
    }

    final private function getTableName() {
        $matches = array();
        preg_match('|^.*\\\((?:[A-Z][a-z]+)+)Model$|', static::class, $matches);
        return substr(strtolower(preg_replace('|[A-Z]|', '_$0', $matches[1])), 1);
    }

    protected function getFields () {
        return array();
    }

    final public function add (array $data) {

        $fields = $this->getFields();

        $supportedFieldsNames = array_keys($fields);
        $requestedFieldsNames = array_keys($data);

        foreach ($requestedFieldsNames as $requestedFieldsName) {
            if (!in_array($requestedFieldsName, $supportedFieldsNames)) {
                throw new \Exception('Polje koje ste uneli ' . $requestedFieldsName . ' nije podrzano.');
            }

            if (!$fields[$requestedFieldsName]->isEditable()) {
                throw new \Exception('Polje '.$requestedFieldsName . ' ne moze da se menja.');
            }

            if (!$fields[$requestedFieldsName]->isValid($data[$requestedFieldsName])) {
                throw new \Exception('Polje '.$requestedFieldsName . ' nije validno.');
            }
        }

        return $this->insertToDb($data);
    }

    final public function insertToDb (array $data) {
        $tableName = $this->getTableName();
        $sqlFieldNames = implode(', ', array_keys($data));
        $questionMarks = str_repeat('?,', count($data));
        $questionMarks = substr($questionMarks, 0, -1);

        $sql = "INSERT INTO {$tableName} ({$sqlFieldNames}) VALUES ({$questionMarks});";

        $prep = $this->dbc->getConnection()->prepare($sql);
        $result = $prep->execute(array_values($data));

        if (!$result) {
            return false;
        }
        return $this->dbc->getConnection()->lastInsertId();
    }

    public function getById ($userId) {
        $object = null;
        $sql = "SELECT * FROM ". $this->getTableName() ." WHERE {$this->getTableName()}_id = ?;";

        $prep = $this->dbc->getConnection()->prepare($sql);
        $res = $prep->execute([$userId]);

        if ($res) {
            $object = $prep->fetch(\PDO::FETCH_OBJ);
        }
        return $object;
    }

    public function getAll() {
        $objects = null;
        $sql = "SELECT * FROM ". $this->getTableName();

        $prep = $this->getConnection()->prepare($sql);
        $result = $prep->execute();
        if ($result) {
            $objects = $prep->fetchAll(\PDO::FETCH_OBJ);
        }
        return $objects;

    }

    public function getByFieldName ($fieldName, $value) {
        $object = null;

        $sql = "SELECT * FROM ".$this->getTableName()." WHERE ".$fieldName. " = ?;";
        $prep = $this->getConnection()->prepare($sql);
        $result = $prep->execute([$value]);
        if ($result) {
            $object = $prep->fetchAll(\PDO::FETCH_OBJ);
        }
        return $object;
    }

    public function getOneByFieldName ($fieldName, $value) {
        $object = null;

        $sql = "SELECT * FROM ".$this->getTableName()." WHERE ".$fieldName. " = ?;";
        $prep = $this->getConnection()->prepare($sql);
        $result = $prep->execute([$value]);
        if ($result) {
            $object = $prep->fetch(\PDO::FETCH_OBJ);
        }
        return $object;
    }
}