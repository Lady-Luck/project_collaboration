<?php namespace App\src\models;

use App\src\core\Field;
use App\src\validators\StringValidator;
use App\src\validators\EmailValidator;

class JobModel extends Model {

    protected function getFields() {

        $fields = array(
            'name' => new Field(new StringValidator(), true),
            'user_id' => new Field(new StringValidator(), true),
            'project_id' => new Field(new StringValidator(), true),
            'deadline' => new Field(new StringValidator() ,true),
            'description' => new Field(new StringValidator() ,true),
            'progress' => new Field(new StringValidator() ,true),
        );
        return $fields;
    }

    public function applyToJob ($userId, $jobId) {
        $sql = "UPDATE jobs SET user_id = ? WHERE ID = ?;";

        $prep = $this->getConnection()->prepare($sql);
        $result = $prep->execute([$userId, $jobId]);

        if (!$result) {
            return false;
        }
        return true;
    }

}